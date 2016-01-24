<?php namespace NourritureToolbox\Registrar\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use NourritureToolbox\Registrar\Exception\NonUniqueException;
use NourritureToolbox\Registrar\RegistrationExecutor;

class DefaultController extends Controller
{
    public function createRegistration(Request $request)
    {
        $email = $request->query('email');

        /** @var RegistrationExecutor $registrationExecutor */
        $registrationExecutor = app('nour.registration_executor');

        $data = [
            'status' => 'ok',
        ];

        try {
            $registrationExecutor->handleEmail($email);
        } catch (NonUniqueException $ex) {
            $data['status'] = 'error';
            $data['error'] = $ex->getMessage();
        }

        return response()->json($data);
    }

    public function validateTicket(Request $request)
    {
        $ticket = $request->query('ticket');

        /** @var RegistrationExecutor $registrationExecutor */
        $registrationExecutor = app('nour.registration_executor');

        $result = $registrationExecutor->validate($ticket);

        $data = [
            'status' => 'ok',
            'data' => $result,
        ];

        return response()->json($data);
    }
}