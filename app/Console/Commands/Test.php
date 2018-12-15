<?php

namespace App\Console\Commands;

use App\Services\Command\CommandAbstract;

/**
 * Class Test
 *
 * @package App\Console\Commands
 */
class Test extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'cron:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command Functionality.';

    /**
     * Command Name for output
     *
     * @var string
     */
    protected $command_name = 'Test Command';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $this->handleStart();

        sleep(4);
        $result = true;

        return $this->handleComplete($result);
    }


}
