<?php
namespace base\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\StringHelper;

use app\models\Curso;

use app\models\Perfil;
use app\models\UsuarioSucursal;
use app\models\Sucursal;
use app\models\TipoDocumentoIdentidad;
use app\models\Localidad;

class UserIdentity extends ActiveRecord implements \yii\web\IdentityInterface
{
    const IDENTITY_COLUMN_ID        = 'id';
    const IDENTITY_COLUMN_AUTH_KEY  = 'auth_key';
    const IDENTITY_COLUMN_TOKEN     = 'token';
    const IDENTITY_COLUMN_USERNAME  = ['email'];
    const IDENTITY_COLUMN_PASSWORD  = 'password';
    const DEFAULT_AVATAR            = '@web/images/dashboard/default-avatar.jpg';
    const WEBROOT_UPLOAD            = '@webroot/images/avatar/';
    const WEB_UPLOAD                = '@web/images/avatar/';

    const PROFILE_ADMIN             = 1;
    const PROFILE_ADMIN_SUCURSAL    = 2;
    const PROFILE_DOCENTE           = 3;
    const PROFILE_ESTUDIANTE        = 4;
    const PROFILE_ESTADISTICAS      = 5;

    use TraitQueriesProfile;
    use TraitActiveRelations;

    public static function tableName()
    {
        return 'usuario';
    }

    public function isAdmin()
    {

        return ($this->id_perfil === static::PROFILE_ADMIN);
    }

    public function isAdminSucursal()
    {

        return ($this->id_perfil === static::PROFILE_ADMIN_SUCURSAL);
    }

    public function isDocente()
    {

        return ($this->id_perfil === static::PROFILE_DOCENTE);
    }

    public function isEstudiante()
    {

        return ($this->id_perfil === static::PROFILE_ESTUDIANTE);
    }

    public function isEstadisticas()
    {
        return ($this->id_perfil === static::PROFILE_ESTADISTICAS);
    }

    public function getDNI()
    {
        $tipoDNI = TipoDocumentoIdentidad::find()->where('id =:id_tipo', [':id_tipo' => $this->id_tipo_doc])->one();

        if(is_null($tipoDNI))
            return;

        return $tipoDNI->codigo . ' ' . $this->nro_documento;
    }

    public function dashboardHome()
    {
        // tmp off
        return false;
        switch(true)
        {
            case $this->isAdmin():
                return Url::toRoute([$this->prefixProfileModule .'/estadisticas']);

            case $this->isAdminSucursal():
                return Url::toRoute([$this->prefixProfileModule .'/estadisticas']);

            case $this->isDocente():
                return Url::toRoute([$this->prefixProfileModule .'/estadisticas']);

            case $this->isEstudiante():
                return Url::toRoute([$this->prefixProfileModule .'/estadisticas']);

            case $this->isEstadisticas():
                return Url::toRoute([$this->prefixProfileModule .'/estadisticas']);

            default:
                return false;
        }
    }

    /*
        retorna un query de sucursales activas segun el perfil
        y la relacion usuario_sucursal
    */
    public function getSucursalesActivas()
    {
        $query = Sucursal::find();
        $query->from(Sucursal::tableName() . ' as s');
        $query->andWhere('s.activo = 1');

        if($this->isAdmin())
            return $query;

        $query->join('INNER JOIN', 'usuario_sucursal as us', 'us.id_sucursal = s.id');
        $query->join('INNER JOIN', 'usuario as u', 'us.id_usuario = u.id');
        $query->andWhere('u.id = :id', [
            ':id' => $this->id
        ]);
        $query->orderBy('s.nombre asc');
        return  $query;
    }

    public function getCursosActivos()
    {
        $query = Curso::find();
        $query->from(Curso::tableName() . ' as c');
        $query->andWhere('c.activo = 1');

        if($this->isAdmin())
            return $query;

        // no activos para los otros usuarios:
        $query->andWhere('1 = 0');
        return $query;
    }

    public function getUsername($flagTruncate = true)
    {
        if($flagTruncate == true)
        {
            $nombres =  $this->nombres .' '. @$this->apellidos[0];
            return StringHelper::truncate($nombres, 10, null) . '.';
        }

        return $this->nombres .' '. $this->apellidos;
    }

    public function getAvatar()
    {
        if(empty($this->imagen_personal))
            return Yii::getAlias(static::DEFAULT_AVATAR);

        $image = Yii::getAlias(static::WEBROOT_UPLOAD . $this->imagen_personal);

        if(!is_file($image) || !is_readable($image))
            return Yii::getAlias(static::DEFAULT_AVATAR);

        return Yii::getAlias(static::WEB_UPLOAD . $this->imagen_personal);
    }

    public  function getPrefixProfileModule()
    {
        switch(true)
        {
            case $this->isAdmin():
                return '/root';

            case $this->isAdminSucursal():
                return '/admin';

            case $this->isDocente():
                return '/docentes';

            case $this->isEstudiante():
                return '/estudiantes';

            case $this->isEstadisticas():
                return '/leo-paparella';

            default:
                return '/';
        }
    }

    /*
    public function delete()
    {
        $db = static::getDb();
        $transaction  = $db->beginTransaction();

        // eliminar de sucursales:
        $db->createCommand()
            ->delete('usuario_sucursal', 'id_usuario = :id', [':id' => $this->id])
            ->execute();

        // eliminar de contactos
        $db->createCommand()
            ->delete('usuario_contacto', 'id = :id', [':id' => $this->id])
            ->execute();

        // agregar mas aqui:
        try{
            $status = parent::delete();
            ($status == true) ? $transaction->commit() : $transaction->rollBack();
            return $status;
        }
        catch(\Exception $e){
            $transaction->rollBack();
            return false;
        }
    }
    */


    ////////////////////////////////////////////////////////////////////////////
    //init region Identity:
    public static function findIdentity($id)
    {
        return static::find()->where(static::IDENTITY_COLUMN_ID .'=:id', [
            ':id' => $id
        ])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where( static::IDENTITY_COLUMN_TOKEN .'=:token' , [
            ':token' => $token
        ])->one();
    }

    public static function findByUsername($username)
    {
        $columns = (is_array( static::IDENTITY_COLUMN_USERNAME )) ? static::IDENTITY_COLUMN_USERNAME : [ static::IDENTITY_COLUMN_USERNAME ];
        $query  = static::find();

        foreach($columns as $key => $column)
        {
            $condition = sprintf('%s=:column_%s', $column, $key);
            $keyParam  = sprintf(':column_%s'   , $key);
            $query->orWhere($condition, [
                $keyParam  => $username
            ]);
        }

        return $query->one();
    }

    public function getId()
    {

        return $this->{static::IDENTITY_COLUMN_ID};
    }

    public function getAuthKey()
    {

        return $this->{static::IDENTITY_COLUMN_AUTH_KEY};
    }

    public function validateAuthKey($authKey)
    {
        if(empty($authKey) || empty($this->{static::IDENTITY_COLUMN_AUTH_KEY}))
            return false;
        else
            return ($this->{static::IDENTITY_COLUMN_AUTH_KEY} === $authKey);
    }

    public function validatePassword($password)
    {
        if(empty($password) || (strlen($password) < 1) )
            return false;

        try{
            return Yii::$app->security->validatePassword($password, $this->{static::IDENTITY_COLUMN_PASSWORD});
        }
        catch(\Exception $e){
            return false;
        }
    }

    public function resetToken()
    {
        if($this->isNewRecord)
            return;

        $this->token = null;
        $this->save(false, ['token']);
        $this->refresh();
    }
}
