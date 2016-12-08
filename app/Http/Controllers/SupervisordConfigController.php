<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class SupervisordConfigController extends Controller
{
    protected $filesystem;

    public function __construct()
    {
        $adapter = new Local(base_path('supervisord'));
        $this->filesystem = new Filesystem($adapter);
    }

    public function view()
    {

        $supervisordFiles = $this->filesystem->listContents();
        $programConfigFiles = [];

        foreach ($supervisordFiles as $file) {
            if ($file['extension'] === 'ini') {
                $programConfigFiles[] = $file;
            }
        }

        return view('config', ['programs' => $programConfigFiles]);
    }

    public function create()
    {


        return view('config.create');
    }

    public function save(Request $request)
    {
        $programName = $request->get('name');

        $programSchema = [
            'program:' . $programName => [
                'command' => $request->get('command'),
            ],
        ];

        $programIni = iniFromArray($programSchema);
        $programIniFile = sprintf('%s.ini', $programName);

        if ($this->filesystem->has($programIniFile)) {
            flash($programName . ' already exists! Edit the existing one instead of pick a different name');

            return redirect()->back();
        }

        $this->filesystem->write($programIniFile, $programIni);

        return redirect('config');
    }
}
