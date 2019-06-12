<?php
/**
 * Email templates
 */

namespace App\Lib;


use App\Model\Table\LogTable;
use Cake\Core\Configure;

class Emails
{

    /**
     * Confirm email
     * @param string $email
     * @param int $userId
     * @return array|bool
     */
    public static function confirm($email, $userId)
    {
        $emailer = new Email('default');
        $result = $emailer->to($email)
            ->subject(Configure::read('App.appName') . ' ' . __('verification email'))
            ->template('register')
            ->setSandboxScript('beforeRegisterEmail')
            ->viewVars(['login' => $email, 'code' => Misc::makeUserCode($userId)])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_confirm', [
            'to'     => $email,
            'vars'   => ['login' => $email, 'code' => Misc::makeUserCode($userId)],
            'result' => $result,
        ], $userId);

        return $result;
    }

    /**
     * Restore email
     * @param string $email
     * @param int $userId
     * @return array|bool
     */
    public static function restore($email, $userId)
    {
        $emailer = new Email('default');
        $result = $emailer->to($email)
            ->subject(Configure::read('App.appName') . ' ' . __('restore email'))
            ->template('restore')
            ->setSandboxScript('beforeRestoreEmail')
            ->viewVars([
                'login' => $email,
                'code'  => Misc::makeRestoreCode($userId),
            ])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_restore', [
            'to'     => $email,
            'vars'   => [
                'login' => $email,
                'code'  => Misc::makeRestoreCode($userId),
            ],
            'result' => $result,
        ], $userId);

        return $result;
    }

    /**
     * New password email
     * @param string $email
     * @param string $newPass
     * @return array|bool
     */
    public static function password($email, $newPass)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            //->emailFormat('html')
            ->subject(Configure::read('App.appName') . ' ' . __('new password'))
            ->template('restore_2')
            ->setSandboxScript('beforeNewPasswordEmail')
            ->viewVars(['login' => $email, 'password' => $newPass])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_password', [
            'to'     => $email,
            'vars'   => ['login' => $email, 'password' => 'somepassword'],
            'result' => $result,
        ]);

        return $result;
    }

    /**
     * KYC fail message
     * @param string $email
     * @param string $status
     * @return array|bool
     */
    public static function kycFail($email, $status)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            //->emailFormat('html')
            ->subject(Configure::read('App.appName') . ' ' . __('KYC failed'))
            ->template('kyc_fail')
            ->setSandboxScript('beforeKYCFailEmail')
            ->viewVars(['login' => $email, 'status' => $status])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_kycfail', [
            'to'     => $email,
            'vars'   => ['login' => $email, 'password' => $status],
            'result' => $result,
        ]);

        return $result;
    }

    /**
     * KYC success message
     * @param string $email
     * @return array|bool
     */
    public static function kycSuccess($email)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            //->emailFormat('html')
            ->subject(Configure::read('App.appName') . ' ' . __('KYC status changed'))
            ->template('kyc_success')
            ->setSandboxScript('beforeKYCSuccessEmail')
            ->viewVars(['login' => $email])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_success', [
            'to'     => $email,
            'vars'   => ['login' => $email],
            'result' => $result,
        ]);

        return $result;
    }

    /**
     * Sends custom message
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return array|bool
     */
    public static function custom($email, $subject, $message)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            ->emailFormat('html')
            ->subject($subject)
            ->template('custom')
            ->viewVars(['content' => $message])
            ->send();

        return $result;
    }

    /**
     * New transaction created
     * @param string $email
     * @param float $amount
     * @param string $currency
     * @return array|bool
     */
    public static function newTransaction($email, $amount, $currency)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            ->subject(Configure::read('App.appName') . ': ' . __('new transaction created'))
            ->template('transaction_new')
            ->setSandboxScript('beforeNewTransactionEmail')
            ->viewVars([
                'login' => $email,
                'amount' => $amount,
                'currency' => $currency,
            ])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_transaction_new', [
            'to'     => $email,
            'vars'   => ['login' => $email, 'amount' => $amount, 'currency' => $currency],
            'result' => $result,
        ]);

        return $result;
    }

    /**
     * Receipt the funds by user(non deposit)
     * @param string $email
     * @param float $tokenCount
     * @param float $amount
     * @param string $currency
     * @return array|bool
     */
    public static function receiptFunds($email, $tokenCount, $amount, $currency)
    {
        $mail = new Email('default');
        $result = $mail->to($email)
            ->subject(Configure::read('App.appName') . ': ' . __('receipt funds'))
            ->template('receipt_funds')
            ->setSandboxScript('beforeReceiptFundsEmail')
            ->viewVars([
                'tokens' => $tokenCount,
                'amount' => $amount,
                'currency' => $currency,
            ])
            ->send();

        if ($result === false) {
            return false;
        }

        LogTable::write('EMAIL_receipt_funds', [
            'to'     => $email,
            'vars'   => ['tokens' => $tokenCount, 'amount' => $amount, 'currency' => $currency],
            'result' => $result,
        ]);

        return $result;
    }
}