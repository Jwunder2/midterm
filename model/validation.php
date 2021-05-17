<?php



//Return true if a food is valid
function validName($inputName)
{
    return strlen(trim($inputName)) >= 2;
}



function validTerms($terms)
{
    $validTerms = getMidTerm();

    //Make sure each selected condiment is valid
    foreach ($terms as $userTerms) {
        if (!in_array($userTerms, $validTerms)) {
            return false;
        }
    }

    //All choices are valid
    return true;
}