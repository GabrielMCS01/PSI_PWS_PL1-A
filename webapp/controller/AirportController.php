<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AirportController extends BaseController implements ResourceControllerInterface{

    // Função que retorna a View para visualizar todos os aviões
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe todos os aeroportos existentes
            $aeroportos = Airport::all();

            // Retorna a View com a variável com todos os Aeroportos
            return View::make('airports.index', ['airports' => $aeroportos, 'searchbar' => '']);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que retorna a View para Criar um Aeroporto
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Retorna a View com o formulário para o Administrador preencher com os dados do Aeroporto
            return View::make('airports.create');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que cria o Aeroporto e guarda-o na Base de dados
    public function store()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os dados que foram enviados do formulário para criar o Aeroporto
            $aeroporto = Post::getAll();

            // Cria um novo Aeroporto com os dados que foram colocados na variável e guarda o Aeroporto na Base de Dados
            $aeroportos = new Airport($aeroporto);
            $aeroportos->save();

            // Redireciona o administrador para a View de Visualização de todos os Aeroportos
            Redirect::toRoute('airports/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    // Função que retorna a View para editar um Aeroporto
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os atributos do Aeroporto com o ID que foi selecionado para ser editado
            $aeroporto = Airport::first([$id]);

            // Retorna a View para editar o Aeroporto, com os dados do Aeroporto selecionado
            return View::make('airports.edit', ['aeroporto' => $aeroporto]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que recebe e atualiza os dados do Aeroporto editado na View edit
    public function update($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Recebe os dados do ID do Aeroporto que irá ser atualizado
            $aeroporto = Airport::first([$id]);

            // atribui os valores que são recebidos do formulário preenche-os na variável e guarda na Base de dados
            $aeroporto->update_attributes(Post::getAll());
            $aeroporto->save();

            // Retorna a View para se visualizar todos os Aeroportos
            Redirect::toRoute('airports/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // A variável recebe os atributos do Aeroporto com o ID selecionado
            $aeroporto = Airport::first([$id]);

            // Apaga o Aeroporto selecionado anteriormente
            $aeroporto->delete();

            // Redireciona o administrador para a View (index) de Visualização de todos os Aeroportos
            Redirect::toRoute('airports/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function search()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            $searching = Post::get('search');

            $search = Airport::find('all', array('conditions' =>
                "airportname LIKE '%$searching%' OR 
                country LIKE '%$searching%' OR
                city LIKE '%$searching%'
                "));
            return View::make('airports.index', ['airports' => $search, 'searchbar' => $searching]);
        } else {
            Redirect::toRoute('users/index');
        }
    }
}
?>