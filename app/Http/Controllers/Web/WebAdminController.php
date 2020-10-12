<?php

namespace tiendaVirtual\Http\Controllers\Web;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\AdminController;
use tiendaVirtual\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Requests\UpdatePasswordFormRequest;

class WebAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lleva a la página de inicio de administrador
        return view('admin.inicio');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.crearAdmin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'email' => $data['userEmail'],
            'name' => $data['userName'],
            'password' => $data['password']
        ];
        $reponse = AdminController::store($body);
        if($reponse){
            return redirect('/admin/new/admin')->with('flash_message_success', '¡Se ha creado un nuevo Administrador!');
        }
        else {
            return redirect('/admin/new/admin')->with('flash_message_error', '¡El correo introducido ya existe!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'currentPassword' => $data['currentPassword'],
            'newPassword' => $data['newPassword']
        ];
        $reponse = AdminController::updatePassword($body);
        if($reponse){
            return redirect('/admin/index')->with('flash_message_success', 'Su contraseña ha sido actualizada.');
        }
        else {
            return redirect('/admin/password/change')->with('flash_message_error', 'Contraseña actual incorrecta.');
        }
    }

    /**
     * Returns to admin login page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loginPage()
    {
        return view('admin.login');
    }

    /**
     * Returns to admin login page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loginAdmin(LoginFormRequest $request)
    {
        $data = $request->validated(); //Son las etiquetas del html, obitene lo que están en ellos
        $body = ['email'=>$data['email'],'password'=>$data['password']];
        $reponse = AdminController::loginAdmin($body);
        if($reponse){
            return redirect('admin/product/index');
        }
        else{
            return redirect('/admin')->with('flash_message_error', 'Usuario o Contraseña incorrectos.');
        }
    }

    public static function configurations() {
        /*Lleva a la página de las configuariones*/
        self::checkIsAdminUser();//Verifica que el usuario logueado sea administrador
        return view('admin.configuraciones');
    }

    private static function checkIsAdminUser(){
        /*Verifica que haya alguien logueado y si hay alguien, verifica que sea admin*/
        $user = Auth::user();
        if(!$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
    }

    public static function logout() {
        /*Cierra la sesión actual, en este caso, de la sesión del administrador*/
        Auth::logout();
        return redirect('/cliente')->with('flash_message_success', '¡Cierre de sesión completo!');
    }

    public static function checkPassword(Request $request) {
        /*Compara la contraseña ingresada con la que está registrada en la base de datos
        Retorna true si coinciden, false caso contrario*/
        $data = $request->all();
        $body = ['password' => $data['ctr_actual']]; // Contiene la contraseña ingresada por el usuario
        $reponse = AdminController::checkPassword($body);
        if($reponse){
            echo "true"; die;
        }
        else{
            echo "false"; die;
        }
    }

}
