<?php

    use Slim\Http\Request;
    use Slim\Http\Response;
    use App\Models\Produto;
    use App\Models\Usuario;
    
    use Firebase\JWT\JWT as JWT;

    $app->post('/api/token', function($request, $response, $args){

        $dados = $request->getParsedBody();

        $email = $dados['email'] ?? null;
        $senha = $dados['senha'] ?? null;

        $usuario = Usuario::where('email', $email)->first();

        if( !is_null($usuario) && (md5($senha) === $usuario->senha)){

            $secretKey = $this->get("settings")['secretKey'];
            $user = [
                "id" => $usuario->id,
                "nome" => $usuario->nome,
                "email" => $usuario->email,
                "senha" => $usuario->senha,
            ];
            $token = JWT::encode($user, $secretKey, 'HS256');

            return $response->withJson([
                'chave' => $token
            ]);

        }

        return $response->withJson([
            'status' => 'erro'
        ]);

    });

?>