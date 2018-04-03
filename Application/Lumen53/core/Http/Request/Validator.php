<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 4/10/17
 * Time: 8:13 PM
 */

//https://github.com/vlucas/valitron
namespace Application\Lumen53\Http\Request;

use Valitron\Validator as ArrayValidator;
use Application\Lumen53\Exceptions\ApplicationException;

class Validator{

    public function requestValidator($data,$rules)
    {
        $request = new ArrayValidator($data);
        $request->mapFieldsRules($rules);

        if(!$request->validate()){
            $errors = $this->toMessage($request->errors());
            throw new ApplicationException($errors,'401');
        }
    }


    private function toMessage($errors)
    {
        $message = "";

        foreach ($errors as $field=>$rules){
            foreach($rules as $rule){
                $message .= $rule .', ';
            }
        }

        $message = rtrim($message,', ');
        return $message;
    }
}