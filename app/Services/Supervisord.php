<?php

namespace App\Services;

use Exception;
use ReflectionClass;
use Zend\Http\Client as HttpClient;
use Zend\XmlRpc\Client as XmlRpcClient;

/**
 * Class Supervisord
 * @package App\Services
 */
class Supervisord
{
    const START_PROCESS = 'supervisor.startProcess';
    const STOP_PROCESS = 'supervisor.stopProcess';
    const ADD_PROCESS_GROUP = 'supervisor.addProcessGroup';
    const CLEAR_ALL_PROCESS_LOGS = 'supervisor.clearAllProcessLogs';
    const CLEAR_LOG = 'supervisor.clearLog';
    const CLEAR_PROCESS_LOG = 'supervisor.clearProcessLog';
    const CLEAR_PROCESS_LOGS = 'supervisor.clearProcessLogs';
    const GET_API_VERSION = 'supervisor.getAPIVersion';
    const GET_ALL_CONFIG_INFO = 'supervisor.getAllConfigInfo';
    const GET_ALL_PROCESS_INFO = 'supervisor.getAllProcessInfo';
    const GET_IDENTIFICATION = 'supervisor.getIdentification';
    const GET_PID = 'supervisor.getPID';
    const GET_PROCESS_INFO = 'supervisor.getProcessInfo';
    const GET_STATE = 'supervisor.getState';
    const GET_SUPERVISOR_VERSION = 'supervisor.getSupervisorVersion';
    const GET_VERSION = 'supervisor.getVersion';
    const READ_LOG = 'supervisor.readLog';
    const READ_MAIN_LOG = 'supervisor.readMainLog';
    const READ_PROCESS_LOG = 'supervisor.readProcessLog';
    const READ_PROCESS_STD_ERROR_LOG = 'supervisor.readProcessStderrLog';
    const READ_PROCESS_STD_OUT_LOG = 'supervisor.readProcessStdoutLog';
    const RELOAD_CONFIG = 'supervisor.reloadConfig';
    const REMOVE_PROCESS_GROUP = 'supervisor.removeProcessGroup';
    const RESTART = 'supervisor.restart';
    const SEND_PROCESS_STD_IN = 'supervisor.sendProcessStdin';
    const SEND_REMOTE_COMM_EVENT = 'supervisor.sendRemoteCommEvent';
    const SHUTDOWN = 'supervisor.shutdown';
    const SIGNALL_ALL_PROCESSES = 'supervisor.signalAllProcesses';
    const SIGNAL_PROCESS = 'supervisor.signalProcess';
    const SIGNAL_PROCESS_GROUP = 'supervisor.signalProcessGroup';
    const START_ALL_PROCESSES = 'supervisor.startAllProcesses';
    const START_PROCESS_GROUP = 'supervisor.startProcessGroup';
    const STOP_ALL_PROCESSES = 'supervisor.stopAllProcesses';
    const STOP_PROCESS_GROUP = 'supervisor.stopProcessGroup';
    const TAIL_PROCESS_LOG = 'supervisor.tailProcessLog';
    const TAIL_PROCESS_STD_ERROR_LOG = 'supervisor.tailProcessStderrLog';
    const SYSTEM_LIST_METHODS = 'system.listMethods';
    const SYSTEM_METHOD_HELP = 'system.methodHelp';
    const SYSTEM_METHOD_SIGNATURE = 'system.methodSignature';
    const SYSTEM_MULTICALL = 'system.multicall';

    /**
     * @var XmlRpcClient
     */
    protected static $xmlRpcClient;

    /**
     * @var bool
     */
    protected static $prepared = false;

    /**
     * Initializes the connection to supervisord
     */
    protected static function init()
    {
        try {
            $httpClient = new HttpClient();
            $httpClient->setAuth('user', '123');

            $client = new XmlRpcClient(
                'http://127.0.0.1:9001/RPC2',
                $httpClient
            );

            self::$xmlRpcClient = $client;
            self::$prepared = true;
        } catch (Exception $exception) {
            echo 'Failed...' . $exception->getMessage();
        }
    }

    /**
     * @param $rpc
     * @param array $params
     * @return array
     */
    public static function call($rpc, array $params = [])
    {
        if (!self::$prepared) {
            self::init();
        }

        return self::$xmlRpcClient->call($rpc, $params);
    }

    /**
     * @return array
     */
    public static function getConstants()
    {
        $supervisord = new ReflectionClass(__CLASS__);

        return $supervisord->getConstants();
    }
}