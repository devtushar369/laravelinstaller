<?php


namespace Hashcode\laravelInstaller\Controllers;


use App\Http\Controllers\Controller;
use Hashcode\laravelInstaller\Models\LicenseDomain;
use Hashcode\laravelInstaller\Services\CheckPermissionService;
use Hashcode\laravelInstaller\Services\CheckRequirementService;

class InstallationController extends Controller
{

    public function welcome()
    {
        return view('laravelInstaller::welcome');
    }

    public function checkRequirement()
    {
        $requirements = (new CheckRequirementService)->requirement();
        return view('laravelInstaller::check_requirement', compact('requirements'));
    }

    public function checkPermission()
    {
        $file = storage_path('app/requirementChecked');
        touch($file);

        $requirements = (new CheckPermissionService)->permissions();
        return view('laravelInstaller::check_permission', compact('requirements'));
    }


    public function completed()
    {
        $file = storage_path('app/adminSetuped');
        $fileCompleted = storage_path('app/installed');
        touch($file);
        touch($fileCompleted);

        $user['email'] = session('email');
        $user['password'] = session('password');

        return view('laravelInstaller::completed')->with($user);
    }
}
