<?php
    $Sucesso = 0;
    $Falha= 0;
function my_file_get_contents( $site_url ){
    $ch = curl_init();
    $timeout = 10; // set to zero for no timeout
    curl_setopt ($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "COOKIE.TXT");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($ch, CURLOPT_VERBOSE, false);
    ob_start();
    curl_exec($ch);
    curl_close($ch);
    $file_contents = ob_get_contents();
    ob_end_clean();
    return $file_contents;
}

function VotePost($site_url,$AToken){
    $ch = curl_init();
    $timeout = 1800; // set to zero for no timeout
    curl_setopt ($ch, CURLOPT_URL, $site_url);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "COOKIE.TXT");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_NOBODY, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "utf8=%E2%9C%93&authenticity_token=".$AToken);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_setopt ($ch, CURLOPT_VERBOSE, false);
    ob_start();
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $file_contents = ob_get_contents();
    ob_end_clean();
    return $http_status;


}    
echo "\x1b[31m[ * ]\x1b[32m Bem Vindo ao Bot\n\x1b[31m[ * ]\x1b[32m Bot Criado Por : \x1b[31mScripterOficial\n\n";

while(true){
    $url = 'https://adfreeway.com/myaccount/content';
    $page = my_file_get_contents($url);
    $RegexDoSaldo = "#var balance = (.*?);#";
    preg_match($RegexDoSaldo,$page,$ResultadoDoSaldo);
    $SaldoAtual = str_replace("var balance = ", "", $ResultadoDoSaldo[0]);
    $SaldoAtual = str_replace(";", "", $SaldoAtual);
    echo "\x1b[31m[ * ]\x1b[32m Seu Saldo Atual É : \x1b[31m". $SaldoAtual."\n";
    $RegexDoHash = '#"page_hash" value="(.*)"#';
    preg_match($RegexDoHash,$page,$ResultadoDoHash);
//   echo "\x1b[31m[ * ]\x1b[32m Sua Hash Atual É : \x1b[31m". $ResultadoDoHash[1]."\n";
    $UrlDoHash = 'https://adfreeway.com/content_feed?page_hash='.$ResultadoDoHash[1];
    $PaginaDoHash = my_file_get_contents($UrlDoHash);
    // Pega O Token Para Requisição Up
    $RegexParaListarPostsUp = "#/content/(.*)/up/vote#i";
    preg_match($RegexParaListarPostsUp,$PaginaDoHash,$ResultadoDosPostsUp);
    // Pegar Os Tokens
    $RegexDoToken= '#"authenticity_token" value="(.*)"#';
    preg_match_all($RegexDoToken,$PaginaDoHash,$ResultadoDoToken);
    // Pega O Token Para Requisição Down
    $RegexParaListarPostsDown = "#/content/(.*)/down/vote#i";
    preg_match($RegexParaListarPostsDown,$PaginaDoHash,$ResultadoDosPostsDown);

    echo "\x1b[31m[ * ]\x1b[32m O Bot Está Escolhendo Como Vai Interagir Com o Post\n";
    $EscolhaTipo = random_int(1, 2);
    if ($EscolhaTipo == 1) {
        echo "\x1b[31m[ * ]\x1b[32m O Bot Escolheu : \x1b[31mLike\n";
        $UrlDoPostVotado = 'https://adfreeway.com'.$ResultadoDosPostsUp[0];
        echo "\x1b[31m[ * ]\x1b[32m O Bot Está Acessando Uma Pagina\n";   
//        echo "\x1b[31m[ * ]\x1b[32m A Url Da Postagem É : \x1b[31m".$UrlDoPostVotado."\n";
        $TokenCorrigido = $ResultadoDoToken[1][0];
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
//        echo "\x1b[31m[ * ]\x1b[32m O Token É : \n\x1b[31m".$TokenCorrigido."\n";
        $PaginaDoPost = VotePost($UrlDoPostVotado, $TokenCorrigido);

    }
    if ($EscolhaTipo == 2) {
        echo "\x1b[31m[ * ]\x1b[32m O Bot Escolheu : \x1b[31mDeslike\n";
        $UrlDoPostVotado = 'https://adfreeway.com'.$ResultadoDosPostsDown[0];
        echo "\x1b[31m[ * ]\x1b[32m O Bot Está Acessando Uma Pagina\n";        
/////       echo "\x1b[31m[ * ]\x1b[32m A Url Da Postagem É : \x1b[31m".$UrlDoPostVotado."\n";
        $TokenCorrigido = $ResultadoDoToken[1][1];
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("+", "%2B", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
        $TokenCorrigido =str_replace("/", "%2F", $TokenCorrigido);
//        echo "\x1b[31m[ * ]\x1b[32m O Token É : \n\x1b[31m".$TokenCorrigido."\n";
        $PaginaDoPost = VotePost($UrlDoPostVotado, $TokenCorrigido);

    }
    if ($PaginaDoPost==422){
        echo "\x1b[31m[ * ]\x1b[32m Um Problema Foi Encontrado : \x1b[31m422 \n";
        $Falha++;
    } else {
       echo "\x1b[31m[ * ]\x1b[32m Ação Concluida Com Sucesso.\n";
       $Sucesso++;
    }
    echo "\x1b[31m[ * ]\x1b[32m Estado do Bot : \x1b[31m [ ". $Sucesso." \x1b[32m Sucesso(s) / \x1b[31m".$Falha." \x1b[32m Falha(s)\x1b[31m ]\n";
    echo "\x1b[31m[ * ]\x1b[31m Esperando 1 Segundos Antes de Continuar\n\n";
    sleep(1);

}
    ?>