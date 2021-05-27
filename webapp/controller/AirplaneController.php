<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AirplaneController extends BaseController implements ResourceControllerInterface{

    // Função que retorna a View para visualizar todos os aviões
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe todos os aviões existentes
            $avioes = Airplane::all();

            // Retorna a View com a variável com todos os aviões
            return View::make('airplanes.index', ['airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que retorna a View para Criar um avião
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // Retorna a View com o formulário para o Administrador preencher com os dados do avião
            return View::make('airplanes.create');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que cria o avião e guarda na Base de dados
    public function store()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os dados que foram enviados do formulário para criar o avião
            $aviao = Post::getAll();

            // Cria um novo avião com os dados que foram colocados na variável
            $aviao = new Airplane($aviao);

            // Guarda o avião na Base de Dados
            $aviao->save();

            // Redireciona o utilizador para a View de Visualização de todos os aviões
            Redirect::toRoute('airplanes/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    // Função que retorna a View para editar um avião
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe o ID do avião que foi selecionado para ser editado
            $aviao = Airplane::first([$id]);

            // Retorna a View para editar o avião, com os dados do avião
            return View::make('airplanes.edit', ['airplane' => $aviao]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que recebe e atualiza os dados do avião editado na View edit
    public function update($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // Recebe os dados do ID do avião que irá ser atualizado
            $aviao = Airplane::first([$id]);

            // atribui os valores que são recebidos do formulário preenchido á variável e guarda na Base de dados
            $aviao->update_attributes(Post::getAll());
            $aviao->save();

            // Retorna a View para se visualizar todos os aviões
            Redirect::toRoute('airplanes/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os valores do ID do avião
            $aviao = Airplane::first([$id]);

            $mensagemErro = "";

            if($aviao->flight == null) {
                // Apaga o avião selecionado anteriormente
                $aviao->delete();
            }else{
                \Tracy\Dumper::dump("Elimina primeiros os voos caralho!");
                $mensagemErro = "Não foi possivel eliminar o avião porque tem voos associados.";
            }

            // Retorna a View para se visualizar todos os aviões
            Redirect::toRoute('airplanes/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>