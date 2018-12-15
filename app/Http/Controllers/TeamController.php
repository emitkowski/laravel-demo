<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\TeamRequest;
use App\Models\Address;
use App\Models\ContactMethod;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Jrean\UserVerification\Facades\UserVerification;
use Laravel\Spark\Events\Teams\TeamMemberAdded;
use Laravel\Spark\Spark;

/**
 * Class TeamController
 *
 * @package App\Http\Controllers\Portal
 */
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();

        return view('portal.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portal.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTeamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTeamRequest $request)
    {
        $data = $request->all();

        $user = User::forceCreate([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt(Str::random(32)),
            'license_number' => $data['license_number'],
            'license_state' => (isset($data['license_state']) ? $data['license_state'] : null),
            'last_read_announcements_at' => Carbon::now()
        ]);

        $team = Spark::team()->forceCreate([
            'owner_id' => $user->id,
            'name' => $data['name'],
            'type' => $data['type'],
            'business_type' => $data['business_type'],
            'error_omission_policy_number' => $data['error_omission_policy_number'],
            'error_omission_carrier_name' => $data['error_omission_carrier_name'],
            'error_omission_exp_date' => Carbon::parse($data['error_omission_exp_date']),
            'approved_at' => Carbon::now()
        ]);

        $user->assignRole('owner');
        $user->currentTeam();

        // Add owner to team
        $team->users()->attach($user, ['role' => 'owner']);
        event(new TeamMemberAdded($team, $user));

        // Save physical Addresses
        $address = new Address();
        $address->type = 'physical';
        $address->address = $data['address'];
        $address->address2 = $data['address2'];
        $address->city = ucwords($data['city']);
        $address->state = $data['state'];
        $address->postal = $data['zip'];
        $address->country = 'US';
        $address->default = 1;
        $team->addresses()->save($address);

        // Save mailing address
        if ($data['diff_addr'] == 'yes') {
            $address = new Address();
            $address->type = 'mailing';
            $address->address = $data['mailing_address'];
            $address->address2 = $data['mailing_address2'];
            $address->city = ucwords($data['mailing_city']);
            $address->state = $data['mailing_state'];
            $address->postal = $data['mailing_zip'];
            $address->country = 'US';
            $address->default = 1;
            $team->addresses()->save($address);
        } else {
            $address = new Address();
            $address->type = 'mailing';
            $address->address = $data['address'];
            $address->address2 = $data['address2'];
            $address->city = ucwords($data['city']);
            $address->state = $data['state'];
            $address->postal = $data['zip'];
            $address->country = 'US';
            $address->default = 1;
            $team->addresses()->save($address);
        }

        // Save Phone
        $phone = new ContactMethod();
        $phone->type = 'phone';
        $phone->subtype = 'office';
        $phone->value = $data['phone'];
        $team->contacts()->save($phone);

        // Save Website
        $website = new ContactMethod();
        $website->type = 'website';
        $website->value = $data['website'];
        $team->contacts()->save($website);

        $user->fresh();
        $user->load('teams');

        $user->generateNetRatePassword();

        // User Verification Emails
        UserVerification::generate($user);
        UserVerification::send($user, 'Please verify your email');

        flash()->success($team->name . " Created.");

        $pluralTeamString = str_plural(Spark::teamString());

        return redirect(route($pluralTeamString . '.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('portal.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Team $team)
    {
        return view('portal.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeamRequest|\Illuminate\Http\Request $request
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, Team $team)
    {
        $data = $request->all();

        $team->forceFill($request->except(['_method', '_token', 'error_omission_exp_date']));

        $team->error_omission_exp_date = Carbon::parse($data['error_omission_exp_date']);

        if ($team->isDirty()) {
            $team->save();
            flash()->success($team->name . " Updated.");
        } else {
            flash()->info("No changes.");
        }

        return redirect(route(str_plural(Spark::teamString()).'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Team $team)
    {
        try {
            //todo  Detach all user before delete

            $team->delete();
        } catch (QueryException $exception) {
            flash()->error("This could not be deleted because it is in use.");

            return back();
        }

        flash()->success($team->name . " Deleted.");

        return redirect(route(str_plural(Spark::teamString()).'.index'));
    }

    /**
     * Activate team
     *
     * @param Team $team
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activate(Team $team)
    {
        $team->activate();

        flash()->success($team->name . " Activated.");

        return redirect(route(str_plural(Spark::teamString()).'.index'));
    }

    /**
     * Deactivate team
     *
     * @param Team $team
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deactivate(Team $team)
    {
        $team->deactivate();

        flash()->success($team->name . " Deactivated.");

        return redirect(route(str_plural(Spark::teamString()).'.index'));
    }

    /**
     * Get Team list
     *
     * @param Team $team_model
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAll(Team $team_model)
    {
        $teams = $team_model->select('id', 'name')->orderBy('name')->get();

        return response()->json(['agencies' => $teams]);
    }
}
