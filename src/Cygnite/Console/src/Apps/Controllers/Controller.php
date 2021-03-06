namespace {%Apps%}\Controllers;

use Cygnite\FormBuilder\Form;
use Cygnite\Common\Input\Input;
use Cygnite\Validation\Validator;
use Cygnite\Common\UrlManager\Url;
use Cygnite\Foundation\Application;
use Cygnite\Http\Responses\Response;
use {%Apps%}\Form\%ControllerName%Form;
use {%Apps%}\Models\%StaticModelName%;
use Cygnite\Mvc\Controller\AbstractBaseController;

/**
* This file is generated by Cygnite CLI
* You may alter code to fit your needs
*/

class {%ControllerClassName%}Controller extends AbstractBaseController
{
    /* If you are using twig template you don't require to set layout */
    //protected $layout = '';

    protected $templateEngine = true;

    //protected $templateExtension = '.html.twig';

    protected $autoReload = true;

    protected $twigDebug = true;

    /**
    * Your constructor.
    * @access public
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Default method for your controller. Render welcome page to user.
    * @access public
    *
    */
    public function indexAction()
    {
        $%controllerName% = [];
        $%controllerName% = %StaticModelName%::all(['orderBy' => '{%primaryKey%} desc',
                /*'paginate' => array(
                    'limit' => Url::segment(3)
                )*/
            ]
        );
        $flash = null;

        // Check if flash message exists, render if flash message set
        if ($this->hasFlash('success')) {
            $flash = $this->getFlash('success');
        } elseif ($this->hasError()) {
            $flash = $this->getFlash('error');
        }

        $view = $this->render('%controllerName%.index', [
                'records' => $%controllerName%,
                'flashMessage' => $flash,
                'links' => '', //%StaticModelName%::createLinks()
                'title' => 'Cygnite Framework - Crud Application'
        ], true);
        
        return Response::make($view);
    }

    /**
     * Add a new %controllerName%
     * @return void
     */
    public function addAction()
    {
        $form = new %ControllerName%Form();
        $form->action = 'add';
        $input = Input::make();

        //Check is form posted
        if ($input->hasPost('btnSubmit') == true) {
            $%modelName% = new %StaticModelName%();

            //Run validation
            if ($%modelName%->validate($input->post())) {

                // Get post array value except the submit button
                $postArray = $input->except('btnSubmit')->post();
%modelColumns%
                // Save information into database
                    if ($%modelName%->save()) {
                    $this->setFlash('success', '%ControllerName% added successfully!')
                        ->redirectTo('%controllerName%/index/');
                } else {
                    $this->setFlash('error', 'Error occured while saving %ControllerName%!')
                        ->redirectTo('%controllerName%/index/');
                }

                } else {
                //validation error here
                $form->errors = $%modelName%->validationErrors();
            }

            $form->validator = $%modelName%->getValidator();
        }

        // render view page
        $view = $this->render('%controllerName%.create', [
                'form' => $form->render(),
                'validation_errors' => $form->errors,
                'title' => 'Add a new %ControllerName%'
        ], true);
        
        return Response::make($view);
    }

    /**
     * Update a %controllerName%
     *
     * @param $id
     */
    public function editAction($id)
    {
        $%modelName% = %StaticModelName%::find($id);
        $form = new %ControllerName%Form($%modelName%, Url::segment(3));
        $form->action = 'edit';

        $input = Input::make();

        //Check is form posted
        if ($input->hasPost('btnSubmit') == true) {

            //Run validation
            if ($%modelName%->validate($input->post())) {

                // get post array value except the submit button
                $postArray = $input->except('btnSubmit')->post();
%modelColumns%
                // Save form information
                if ($%modelName%->save()) {
                    $this->setFlash('success', '%ControllerName% updated successfully!')
                        ->redirectTo('%controllerName%/index/');
                } else {
                    $this->setFlash('error', 'Error occured while saving %ControllerName%!')
                        ->redirectTo('%controllerName%/index/');
                }

            } else {
                //Set validation error into form builder
                $form->errors = $%modelName%->validationErrors();
            }

            $form->validator = $%modelName%->getValidator();
        }

         // render view page
        $view = $this->render('%controllerName%.update', [
                'form' => $form->render(),
                'validation_errors' => $form->errors,
                'title' => 'Update %ControllerName%'
        ], true);
        
        return Response::make($view);
    }

    /**
    * Display product details
    * @param type $id
    */
    public function showAction($id)
    {
        $%modelName% = %StaticModelName%::find($id);

        // render view page
        $view = $this->render('%controllerName%.show', [
                'record' => $%modelName%,
                'title' => 'Show a %ControllerName%'
        ], true);
        
        return Response::make($view);
    }

    /**
    * Delete %controllerName% using id
    *
    * @param type $id
    */
    public function deleteAction($id)
    {
        $%controllerName% = new %modelName%();
        if ($%controllerName%->trash($id) == true) {
            $this->setFlash('success', '%ControllerName% Deleted Successfully!')
                 ->redirectTo('%controllerName%/');
        } else {
            $this->setFlash('error', 'Error Occured While Deleting %ControllerName%!')
                 ->redirectTo('%controllerName%/');
        }
    }

}//End of your %ControllerName% controller
