<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\web\Session;


use base\models\UserIdentity as Usuario;
use app\models\forms\RecoveryForm;
use app\models\forms\LoginForm;
use app\models\InscripcionOnline;
use app\models\Sucursal;
use app\models\Config;
use app\models\ConsultarCurso;
use yii\widgets\ActiveForm;
use app\commands\CorreoController;

use base\modules\admin\cursos\models\Curso;

class SiteController extends \base\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error','captcha', 'reset-password', 'recovery', 'test' ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'index',
                            'recovery',
                            'login',
                            'validar-login-ajax',
                            'inscripcion',
                            'validar-inscripcion-ajax',
                            'carreras-cursos',
                            'curso-detalle',
                            'validar-recovery-ajax',
                            'consultar-curso',
                            'consultar-curso-ajax',
                            'reset-password',
                            ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                       // 'actions' => ['index', 'logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST || YII_ENV_DEV ? 'a' : null,
            ],

            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
        {
            $this->view->H1             = Yii::t('app','Inicio');
            $this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
            $this->view->breadcrumbs    = [
                ['label' => Yii::t('yii', 'Home') , 'url' => Yii::$app->homeUrl ]
            ];

            $model = new LoginForm();
            $recovery = new RecoveryForm();
            $config = Config::find()->All();
            if(count($config)<=0)
            {
                $config[0]['nombre']            = 'Escuela Leopaparella';
                $config[0]['facebook']          = 'https://www.facebook.com/Escuela-Leo-Paparella-934184929955798/';
                $config[0]['youtube']           = 'https://www.youtube.com/embed/4Uxb_CHTVL0?autoplay=1';
                $config[0]['instagram']         = 'https://www.instagram.com/escuelaleopaparella/';
            }
            else
                $config[0]['youtube'] = Yii::$app->tools::embeberUlrYoutube( $config[0]['youtube'] , true);

            $sucursales = Sucursal::find()->asArray()->All();

            if ($model->load(Yii::$app->request->post()) && $model->login())
                return $this->goBack();

            $model->password = '';
            return $this->render('index-guest', [
                'model' => $model,
                'config' => $config,
                'recovery' => $recovery,
                'sucursales' => $sucursales,
                'numeroSucursal' =>$sucursales,
            ]);
        }

        $this->view->H1             = Yii::t('app','Dashboard');
        $this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
        $this->view->breadcrumbs    = [
            ['label' => Yii::t('yii', 'Home') , 'url' => Yii::$app->homeUrl ]
        ];

       return $this->render('index');
    }

    public function actionInscripcion()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new InscripcionOnline();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $email = $model->email;
            $username = $model->nombres.' '.$model->apellidos;
            if($model->save())
            {
                CorreoController::sendmail($email,$username);
                return $this->redirect(Url::toRoute(['site/index']));
            }

        }
        return $this->renderAjax('inscripcion', [
            'model' => $model,
        ]);
    }

    public function actionValidarInscripcionAjax()
    {
        $model = new InscripcionOnline();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    public function actionCarrerasCursos()
    {
        $model = Curso::findActivos()->all();

        return $this->renderAjax('cursos', ['model' => $model]);
    }

    public function actionCursoDetalle()
    {
        $id = (int) Yii::$app->request->post('id');

        $model = Curso::findActivos()
            ->andWhere('curso.id = :id', [':id' => $id])
            ->one();

        if(empty($model))
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        //sesion del curso
        $session = new Session();
        $session->open();
        $session->set('curso' ,$model);

        return $this->renderAjax('curso-detalle', ['model'=>$model]);
    }

    public function actionConsultarCurso()
    {
        if (!Yii::$app->user->isGuest)
        {

            return $this->goHome();
        }

        $model = new ConsultarCurso();
        //datos de session de curso detalles
        $curso              = Yii::$app->session->get('curso');
        $cursoDetalle       = [$curso['id'] => $curso['nombre'] ];
        $model->id_curso    = $curso['id'];
        $model->status      = 0;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $username = $model->nombres.' '.$model->apellidos;
            $email    = $model->email;
            if($model->save())
            {
                CorreoController::consultarcurso($email,$username,$curso['nombre']);
                Yii::$app->session->setFlash('success','Se ha enviado la solicitud exitosamente');
                return $this->redirect(Url::toRoute(['site/index']));
            }
        }
        return $this->renderAjax('consultar-curso', [
            'model' => $model,
            'curso' => $cursoDetalle,
        ]);
    }

    public function actionConsultarCursoAjax()
    {
        $model = new ConsultarCurso();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    public function actionLogin()
    {


        $isModalOpen = Yii::$app->request->getQueryParam('modal-load', 0);
        $isModalOpen = $isModalOpen === 0 ? false : true;
        $model       = new LoginForm();

        if($isModalOpen)
        {
            $this->view->iconClass = 'lock';
            $this->view->H1        = Yii::t('app','Iniciar sesión');

            if(Yii::$app->request->isPost)
            {
                if(!Yii::$app->request->isAjax)
                    throw new HttpException(400, Yii::t('app', 'Petición invalida'));
                $model->load( Yii::$app->request->post() );
                if($model->login())
                    return $this->asJson(['status' => true]);

                else{
                    return $this->asJson([
                        'status'     => false,
                        'statusText' => Yii::t('app', 'Credenciales incorrectas... Adios!'),
                    ]);
                }
            }

            return $this->renderAjax('@layouts/login', ['model' => $model ]);
        }

        // el layout de pedro...
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goHome();

        $model->password = '';
        return $this->renderAjax('login', [
            'model' => $model,
        ]);
    }

    public function actionValidarLoginAjax()
    {
        $model = new LoginForm();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRecovery($token = null)
    {
        Yii::$app->user->logout();
        // cuando el usuario le da clik a la url del correo
        if(!is_null($token))
        {
            $user = Usuario::findIdentityByAccessToken($token);
            if(is_null($user))
                return $this->goHome();

            $user->requiere_cambio_pass = 1;
            $user->token = null;
            $user->save(false, ['token', 'requiere_cambio_pass']);

            // refresh token.
            Yii::$app->user->login($user);
            return $this->goHome();
        }

        $model = new RecoveryForm();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate())
        {
            $modelUsuario = Usuario::findByUsername($model->email);
            if (!is_null($modelUsuario))
            {

                $url = Url::toRoute(['/site/recovery', 'token' => $modelUsuario->token], true);
                if($model->sendMail($url)){
                    Yii::$app->session->setFlash('success', 'El envio de mail para refrescar contraseña ha sido exitoso');
                }else{
                    Yii::$app->session->setFlash('error', 'Ha habido un error en el envio de mails');
                }
                return $this->redirect(['site/index']);
            }
        }

        $this->view->H1             = Yii::t('app','Recobrar contraseña de accesos');
        $this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
        $this->view->breadcrumbs    = [
            ['label' => Yii::t('yii', 'Home') , 'url' => Yii::$app->homeUrl ]
        ];

        return $this->renderAjax('recovery', [
            'model' => $model,
        ]);
    }

    public function actionValidarRecoveryAjax()
    {
        $model = new RecoveryForm();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    public function actionResetPassword($token)
    {
        Yii::$app->user->logout();
        $model = Usuario::findIdentityByAccessToken($token);

        if(!is_null($model))
        {
            Yii::$app->user->login($model);
            $model->resetToken();
        }

        return $this->goHome();
    }
}
