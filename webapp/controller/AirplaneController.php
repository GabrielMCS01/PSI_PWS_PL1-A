<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AirplaneController extends BaseController implements ResourceControllerInterface
{

    // Função que retorna a View para visualizar todos os aviões
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe todos os aviões existentes
            $avioes = Airplane::all();

            // Retorna a View com a variável com todos os aviões(array)
            return View::make('airplanes.index', ['airplanes' => $avioes, 'searchbar' => '']);
        } else {
            Redirect::toRoute('users/index');
        }
    }

    // Função que retorna a View para Criar um avião
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Retorna a View com o formulário para o Administrador preencher com os dados do avião
            return View::make('airplanes.create');
        } else {
            Redirect::toRoute('users/index');
        }
    }

    // Função que cria o avião e guarda-o na Base de dados
    public function store()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os dados que foram enviados do formulário para criar o avião
            $aviao = Post::getAll();

            // Cria um novo avião com os dados que foram colocados na variável(array)
            $aviao = new Airplane($aviao);

            // Guarda o avião na Base de Dados
            $aviao->save();

            // Redireciona o administrador para a View de Visualização de todos os aviões
            Redirect::toRoute('airplanes/index');
        } else {
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
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os atributos do avião com o ID que foi selecionado para ser editado
            $aviao = Airplane::first([$id]);

            // Retorna a View para editar o avião, com os dados do avião selecionado
            return View::make('airplanes.edit', ['airplane' => $aviao]);
        } else {
            Redirect::toRoute('users/index');
        }
    }

    // Função que recebe e atualiza os dados do avião editado na View edit
    public function update($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Recebe os dados do ID do avião que irá ser atualizado
            $aviao = Airplane::first([$id]);

            // atribui os valores que são recebidos do formulário, preenche-os na variável e guarda na Base de dados
            $aviao->update_attributes(Post::getAll());
            $aviao->save();

            // Retorna a View para se visualizar todos os aviões
            Redirect::toRoute('airplanes/index');
        } else {
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os atributos do Avião com o ID selecionado
            $aviao = Airplane::first([$id]);

            if ($aviao->flight == null and $aviao->scale == null) {
                // Apaga o avião selecionado anteriormente
                $aviao->delete();
            } else {
                $_SESSION['mensagemErro'] = "Não foi possivel eliminar o avião porque tem voos ou escalas associadas.";
            }

            // Retorna a View (index) para se visualizar todos os aviões
            Redirect::toRoute('airplanes/index');
        } else {
            Redirect::toRoute('users/index');
        }
    }

    public function search()
    {
        // Se tiver sessão iniciada e se o "USER" logado não for um Passageiro, faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Recebe o que estava escrito na Pesquisa
            $searching = Post::get('search');

            // Pesquisa todos por
              $search = Airplane::find('all', array('conditions' =>
                "airplanename LIKE '%$searching%' OR 
                shippingcompany LIKE '%$searching%' OR
                airplanereference LIKE '%$searching%' OR 
                capacity LIKE '%$searching%'
                "));

            // Retorna a View com os argumentos de procura
            return View::make('airplanes.index', ['airplanes' => $search, 'searchbar' => $searching]);
        } else {
            Redirect::toRoute('users/index');
        }
    }
}
?>