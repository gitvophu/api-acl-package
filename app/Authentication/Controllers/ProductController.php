<?php  namespace LaravelAcl\Authentication\Controllers;

/**
 * Class UserController
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use Illuminate\Http\Request;
use View, Redirect, App, Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use LaravelAcl\Library\Form\FormModel;
use LaravelAcl\Authentication\Models\User;
use LaravelAcl\Authentication\Helpers\DbHelper;
use LaravelAcl\Authentication\Helpers\FormHelper;
use LaravelAcl\Authentication\Models\UserProfile;
use LaravelAcl\Library\Exceptions\NotFoundException;
use LaravelAcl\Authentication\Presenters\UserPresenter;
use LaravelAcl\Authentication\Validators\UserValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaravelAcl\Authentication\Services\UserProfileService;
use LaravelAcl\Library\Exceptions\JacopoExceptionsInterface;
use LaravelAcl\Authentication\Exceptions\PermissionException;
use LaravelAcl\Authentication\Validators\UserProfileValidator;
use LaravelAcl\Authentication\Exceptions\UserNotFoundException;
use LaravelAcl\Authentication\Interfaces\AuthenticateInterface;
use LaravelAcl\Authentication\Exceptions\ProfileNotFoundException;
use LaravelAcl\Authentication\Validators\UserProfileAvatarValidator;

class ProductController extends Controller {
    /**
     * @var \LaravelAcl\Authentication\Repository\SentryUserRepository
     */
    protected $user_repository;
    protected $user_validator;
    /**
     * @var \LaravelAcl\Authentication\Helpers\FormHelper
     */
    protected $form_helper;
    protected $profile_repository;
    protected $profile_validator;
    /**
     * @var use LaravelAcl\Authentication\Interfaces\AuthenticateInterface;
     */
    protected $auth;
    protected $register_service;
    protected $custom_profile_repository;

    public function __construct(UserValidator $v, FormHelper $fh, UserProfileValidator $vp, AuthenticateInterface $auth)
    {
        $this->user_repository = App::make('user_repository');
        $this->user_validator = $v;
        //@todo use IOC correctly with a factory and passing the correct parameters
        $this->f = new FormModel($this->user_validator, $this->user_repository);
        $this->form_helper = $fh;
        $this->profile_validator = $vp;
        $this->profile_repository = App::make('profile_repository');
        $this->auth = $auth;
        $this->register_service = App::make('register_service');
        $this->custom_profile_repository = App::make('custom_profile_repository');
    }

    public function getList(Request $request)
    {
        // $users = $this->user_repository->all($request->except(['page']));
        $products = DB::table('products')->get()->toArray();
        // dd($products);
        return View::make('laravel-authentication-acl::admin.product.list')->with(["products" => $products, "request" => $request]);
    }
    
    public function createProduct(Request $request)
    {
        
        return View::make('laravel-authentication-acl::admin.product.create');
    }
    public function storeProduct(Request $request)
    {
        DB::table('products')->insert([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
        ]);
        return redirect()->route('products.list');
    }
    public function updateProduct(Request $request)
    {
       
        DB::table('products')
        ->where('id',$request->id)
        ->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
        ]);
        return redirect()->route('products.list');
    }
    public function editProduct(Request $request)
    {
        $product = DB::table('products')->where('id',$request->id)->first();
        
        return View::make('laravel-authentication-acl::admin.product.edit_product',compact('product'));
    }
    public function deleteProduct(Request $request,$id)
    {
        
        DB::table('products')->where(['id'=>$id])->delete();

        return redirect()->route('products.list');
    }
}
