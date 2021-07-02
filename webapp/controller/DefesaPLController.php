<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class DefesaPLController extends BaseController implements ResourceControllerInterface{

    // Função que retorna a View para visualizar todos os Voos
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
                // A variável recebe todos os Voos existentes
                $voos = Flight::all(['order' => 'datehourdeparture asc']);
            }
            // Retorna a View com a variável com todos os Voos
            return View::make('defesa.index', ['voos' => $voos]);
    }

    /**
     * @return Returns
     */
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            // Recebe da Base de Dados todos os "Aeroportos" e "Aviões"
            $aeroportos = Airport::all();

            // Os "Aeroportos" também são enviados para o Formulário
            return View::make('defesa.create', ['airports' => $aeroportos]);
        }
    }

    /**
     * @return Returns
     */
    public function store()
    {
        if (isset($_SESSION['username'])) {
            // A variável recebe os dados que foram enviados do formulário para criar o Voo
            $oficina = Post::getAll();

            $oficina = new Oficina($oficina);

            // Guarda o Voo na Base de Dados
            $oficina->save();

            // Redireciona o Utilizador para a View de Visualização de todos os Voos
            Redirect::toRoute('defesa/index');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
?>