<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Team;
use App\Models\User;
use App\Notifications\AccountChange;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Jrean\UserVerification\Facades\UserVerification;
use Laravel\Spark\Events\Teams\TeamMemberAdded;
use Spatie\Permission\Models\Role;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Portal
 */
class UserController extends Controller
{
    /**
     * Role Object
     *
     * @var Role
     */
    private $role_model;

    /**
     * Notification Object
     *
     * @var Notification
     */
    private $notification;

    /**
     * UserController constructor.
     *
     * @param Notification $notification
     * @param Role $role_model
     */
    public function __construct(Notification $notification, Role $role_model)
    {
        $this->role_model = $role_model;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $users = $user->getUsersCanManage();

        return view('portal.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role_model->where('name', 'admin')->orWhere('name', 'user')->get();

        $teams = Team::where('status', 1)->orderBy('name')->get();

        return view('portal.users.create', compact('roles', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->forceFill($request->except([
            '_method',
            '_token',
            'license_type',
            'role',
            'team'
        ]));

        // create temp password user will not be able to log in
        // until they confirm email and create password
        $user->password = bcrypt(Str::random(32));
        $user->approved_at = now();
        $user->save();

        // Set Role
        if ($request->input('role')) {
            $user->assignRole($request->input('role'));
        }

        // Set Agency
        if ($request->input('team')) {
            $team = Team::find($request->input('team'));
            $team->users()->attach($user, ['role' => 'member']);
            event(new TeamMemberAdded($team, $user));
        }

        $user->generateNetRatePassword();

        UserVerification::generate($user);
        UserVerification::send($user, 'Please verify your email');

        flash()->success($user->name . " Created.");

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        return view('portal.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $roles = $this->role_model->where('name', 'owner')->orWhere('name', 'user')->get();

        return view('portal.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest|\Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $changes_made = false;
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $user->forceFill($request->except(['_method', '_token', 'password', 'password_confirmation', 'license_type', 'role', 'team']));

        // Set State License
        if ($request->input('license_type') == 'national') {
            $user->license_state = null;
        }

        // Set Password
        $password = $request->input('password');
        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        if ($user->isDirty()) {
            $email_verify = false;
            if ($user->isDirty('email')) {
                $email_verify = true;
            }

            $user->save();

            if ($email_verify) {
                UserVerification::generate($user);
                UserVerification::send($user, 'Please verify your email');
            }
            $changes_made = true;
        }

        if ($changes_made == true) {
            flash()->success($user->name . " Updated.");
        } else {
            flash()->info("No changes.");
        }

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        try {
            $user->delete();
        } catch (QueryException $exception) {
            flash()->error("This could not be deleted because it is in use.");

            return back();
        }

        flash()->success($user->name . " Deleted.");

        return redirect(route('users.index'));
    }

    /**
     * User approve
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $user->approve();

        // Send Notification
        $this->notification->route('mail', $user->email)->notify(new AccountChange($user, 'approved'));

        flash()->success($user->name . " Approved.");

        return redirect()->back();
    }

    /**
     * User activate
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activate(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $user->activate();

        // Send Notification
        $this->notification->route('mail', $user->email)->notify(new AccountChange($user, 'activated'));

        flash()->success($user->name . " Activated.");

        return redirect(route('users.index'));
    }


    /**
     * User deactivate
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deactivate(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $user->deactivate();

        // Send Notification
        $this->notification->route('mail', $user->email)->notify(new AccountChange($user, 'deactivated'));

        flash()->success($user->name . " Deactivated.");

        return redirect(route('users.index'));
    }

    /**
     * User generate new NetRate Password
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function generateNetratePassword(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $user->generateNetRatePassword();

        flash()->success($user->name . " - New NetRate Password Generated.");

        return redirect(route('users.show', [$user->id]));
    }

    /**
     * Promote Agent to Owner
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function promoteAgent(User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        // Set Role
        $user->syncRoles('owner');
        $user->makeTeamOwner($user->currentTeam);

        flash()->success($user->name . " - Promoted to Agency Owner.");

        return redirect(route('users.show', [$user->id]));
    }

    /**
     * Transfer Agent to new agency
     *
     * @param Request $request
     * @param Team $team_model
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function transferAgent(Request $request, Team $team_model, User $user)
    {
        if (!auth()->user()->canManage($user)) {
            return redirect(route('users.index'));
        }

        $team = $team_model->where('id', $request->input('agency_id'))->first();

        if (!$team) {
            return response()->json(['errors' => true, 'message' => 'Agency not found']);
        }

        $owned_teams = $team_model->where('owner_id', $user->id)->get();

        foreach ($owned_teams as $owned_team) {
            $owned_team->owner_id = 0;
            $owned_team->save();
        }

        // Set Role
        $user->syncRoles('user');
        $user->moveToTeam($team);

        flash()->success($user->name . " - Transferred to Agency: " . $team->name);

        return response()->json(['errors' => false]);
    }
}
