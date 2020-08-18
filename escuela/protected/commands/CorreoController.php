<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use base\helpers\mailer\SendMail;

class CorreoController extends Controller
{
    public static function sendmail($email , $username)
    {
        $params = [
            'subject' => 'Inscripción Escuela Leo Paparella',
            'bodyMsn' => '<p>Te damos la bienvenida a la Escuela Leo Paparella. Solicitaste una inscripción. En breve, la sucursal</p>
            <p>que seleccionaste se pondrá en comunicación para asesorarte acerca de la formación quebrindamos.</p><br><br><p>Te esperamos pronto estudiando con nosotros. </p><br><br><p>Saludos.</p><p>Escuela LP</p>',
            'mail' => $email,
            'username' => $username,
            ];
        return SendMail::send($params);
    }

    public static function emailResetPassword($email, $username, $token)
    {
        $params = [
            'subject' => 'Restablecer su contraseña',
            'bodyMsn' => '<p>has pedido recuperar clave</p>
            <p>has click <a href='.$token.' target="_blank">aqui</a>
            para recuperar tu clave. </p><br><br><p>Saludos.</p><p>Escuela LP</p>',
            'mail' => $email,
            'username' => $username,
            ];
        return SendMail::send($params);
    }

    public static function consultarcurso($mail, $username, $curso)
    {
        $params = [
            'subject' => 'Consultar Curso Escuela Leo Paparella',
            'bodyMsn' => '<p>Te damos la bienvenida a la Escuela Leo Paparella. Solicitaste una Consulta del Curso '.$curso.'. En breve,</p>
            <p>nos  comunicaremos contigo para asesorarte acerca de la formación que brindamos.</p><br><br><p>Te esperamos pronto estudiando con nosotros. </p><br><br><p>Saludos.</p><p>Escuela LP</p>',
            'mail' => $mail,
            'username' => $username,
            ];
            SendMail::send($params);
            return ExitCode::OK;
    }
}
