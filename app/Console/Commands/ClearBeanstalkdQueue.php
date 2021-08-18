<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Queue;

class ClearBeanstalkdQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   // protected $signature = 'command:name';
    protected $signature = 'queue:beanstalkd:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getArguments()
	{
		return array(
			array('queue', InputArgument::OPTIONAL, 'The name of the queue to clear.'),
		);
	}

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$queue = ($this->argument('queue')) ? $this->argument('queue') : Config::get('queue.connections.beanstalkd.queue');
        $queue="beanstalkd";
		$this->info(sprintf('Clearing queueuequeue: %s', $queue));

		$pheanstalk = Queue::getPheanstalk();
		$pheanstalk->useTube($queue);
		$pheanstalk->watch($queue);

		while ($job = $pheanstalk->reserve(0)) {			
            $pheanstalk->delete($job);
           $this->info(sprintf('delete'));
    
		}

		$this->info('...cleared.');
    }
}
