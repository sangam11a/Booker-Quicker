<?php

function mails($to_email, $subject, $body, $headers){
    if (mail($to_email, $subject, $body, $headers)) {
        return 1;
    } else {
       return 0;
    }
}