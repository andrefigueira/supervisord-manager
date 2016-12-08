<?php

namespace App\Http\Controllers;

use App\Constants\Supervisord\ProcessState;
use App\Services\Supervisord;
use DateTime;
use Exception;
use Illuminate\Http\Request;

/**
 * Class SupervisordController
 * @package App\Http\Controllers
 */
class SupervisordController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function process(Request $request)
    {
        $action = $request->get('action');
        $processName = $request->get('processName');

        switch ($action) {
            case 'start':
                $actionType = Supervisord::START_PROCESS;
                break;

            case 'stop':
                $actionType = Supervisord::STOP_PROCESS;
                break;
        }

        $success = Supervisord::call($actionType, [
            'name' => $processName,
        ]);

        $result = [
            'success' => false,
            'message' => 'Failed to start ' . $processName,
        ];

        if ($success) {
            $result = [
                'success' => true,
                'message' => sprintf('Action processed (%s): for program (%s)', $actionType, $processName),
                'result' => $success,
            ];
        }

        return $result;
    }

    public function processList()
    {
        try {
            $processes = Supervisord::call(Supervisord::GET_ALL_PROCESS_INFO);

            array_walk($processes, function (&$process) {
                switch ($process['state']) {
                    case ProcessState::STOPPED:
                        $label = 'label-danger';
                        $action = 'start';
                        break;
                    case ProcessState::RUNNING:
                        $label = 'label-success';
                        $action = 'stop';
                        break;

                    default:
                        $label = 'label-default';
                        $action = '';
                }

                $date = new DateTime();
                $date->setTimestamp($process['start']);

                $process['label'] = $label;
                $process['action'] = $action;
                $process['startdate'] = time_elapsed_string($date->format('Y-m-d H:i:s'));
            });

            $result = [
                'success' => false,
                'message' => 'Failed to load process list',
            ];

            if ($processes) {
                $result = [
                    'success' => true,
                    'message' => 'Loaded process list',
                    'data' => $processes,
                ];
            }

            return $result;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $processName
     * @return array
     */
    public function tail(Request $request, $processName)
    {
        $length = $request->get('length');

        if ($length === null) {
            $length = 4096;
        }

        $process = Supervisord::call(Supervisord::GET_PROCESS_INFO, [
            'name' => $processName,
        ]);

        $logLength = filesize($process['stdout_logfile']);

        $logOutput = Supervisord::call(Supervisord::READ_PROCESS_STD_OUT_LOG, [
            'name' => $processName,
            'offset' => $logLength,
            'length' => $length,
        ]);

        $result = [
            'success' => false,
            'message' => 'Failed to fetch the log',
        ];

        if ($logOutput) {
            $result = [
                'success' => true,
                'message' => 'Fetched the log',
                'data' => $logOutput,
            ];
        }

        return $result;
    }
}
