<?php

class ErrorController
{

    public function BadRequestAction()
    {
        echo blade()->run("Errors.400");
    }

    public function NotAuthorizedAction()
    {
        echo blade()->run("Errors.401");
    }

    public function NotFoundAction()
    {
        echo blade()->run("Errors.404");
    }

    public function InternalServerErrorAction()
    {
        echo blade()->run("Errors.500");
    }
}