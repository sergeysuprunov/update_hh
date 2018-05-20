<? 
    $hh_login = 'email@email.com';          // логин на hh.ru
    $hh_password = 'password***password';                       // пароль на hh.ru
    $hh_resumes = [                                     //массив id резюме (взять можно из прямой ссылки на резюме)
        '9b6cb136ff056347a70039ed1f316458685559', 
        '525c848bff05637f3f0039ed1f65764b786177'
    ]; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); 
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'); 
    curl_setopt($curl, CURLOPT_URL, 'https://hh.ru/account/login?backurl=%2Fapplicant%2Fresumes'); 
    $html =  curl_exec($curl);
    preg_match('/<input type="hidden" name="_xsrf" value="(.*)"/Uis', $html, $xsrf);
    $post = "username=" . $hh_login . "&password=" . $hh_password . "&backUrl=https://hh.ru/applicant/resumes&_xsrf=" . $xsrf[1];
    curl_setopt($curl, CURLOPT_URL, 'https://hh.ru/account/login?backurl=%2Fapplicant%2Fresumes');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    $html = curl_exec($curl);
    foreach ($hh_resumes as $hh_resume) {
        $post = "resume=" . $hh_resume . "&undirectable=true";
        curl_setopt($curl, CURLOPT_URL, 'https://hh.ru/applicant/resumes/touch?');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_exec($curl);
    }
    curl_close($curl);
    echo $html;
?>