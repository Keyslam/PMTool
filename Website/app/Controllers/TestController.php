<?php
class TestController {
    public function TestAction() {
        echo blade()->run("test");
    }
}
?>