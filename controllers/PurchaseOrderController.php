<?php

    include_once(__DIR__ . '/Controller.php');
    include_once(__DIR__ . '/../models/PurchaseOrder.php');
    include_once(__DIR__ . '/../utils/functions.php');

    class PurchaseOrderController extends Controller {

        private $model;

        public function __construct() {
            $this->model = new PurchaseOrder();
        }
        
        // Lista todos os registros
        public function index() {

            $field = (!isset($_POST['fieldFilter']) || $_POST['fieldFilter'] == 'Selecione'|| !isset($_POST['fieldValue']) || trim($_POST['fieldValue']) === '') 
                        ? null : ['name' => $_POST['fieldFilter'], 'value' => $_POST['fieldValue']];
            
            $order = (!isset($_POST['fieldOrder']) || $_POST['fieldOrder'] == 'Selecione'|| !isset($_POST['orderType']) || $_POST['orderType'] === 'Selecione') 
            ? null : ['fieldName' => $_POST['fieldOrder'], 'orderType' => $_POST['orderType']]; 
        

            $findAll = $this->model->findAll($field, $order);
            if (is_array($findAll) && count($findAll)) {
                echo json_encode(['status' => '1', 'data' => $findAll]);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao localizar registro, tente novamente.']);
        }

        // Exibe os detalhes do registro selecionado
        public function show() {
            $findById = $this->model->findById(1);
            if (is_array($findById) && count($findById)) {
                echo json_encode(['status' => '1', 'data' => $findById]);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao localizar registro, tente novamente.']);
        }

        public function store() {

            if (!isset($_POST['productId']) || !is_numeric($_POST['productId'])) {
                echo json_encode(['status' => '0', 'msg' => 'Produto inválido, tente novamente.']);
                return;
            }

            if (!isset($_POST['clientId']) || !is_numeric($_POST['clientId'])) {
                echo json_encode(['status' => '0', 'msg' => 'Cliente inválido, tente novamente.']);
                return;
            }

            if (!isset($_POST['qtd']) || !is_numeric($_POST['qtd'])) {
                echo json_encode(['status' => '0', 'msg' => 'Quantidade inválida, tente novamente.']);
                return;
            }

            if (!isset($_POST['status']) || ! $_POST['status'] === 'Selecione') {
                echo json_encode(['status' => '0', 'msg' => 'Status inválido, tente novamente.']);
                return;
            }


            $insert = $this->model->insert($_POST);
            if ($insert) {
                echo json_encode(['status' => '1']);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao inserir registro, tente novamente.']);
        }

        public function update() {
            $arr['qtd'] = '5';
            $arr['status'] = 'Cancelado';

            $updateById = $this->model->updateById(1, $arr);
            if ($updateById) {
                echo json_encode(['status' => '1']);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao localizar registro, tente novamente.']);
        }

        public function destroy() {

            if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
                echo json_encode(['status' => '0', 'msg' => 'O valor do registro não é válido, tente novamente.']);
                return;
            }

            $deleteById = $this->model->deleteById($_POST['id']);
            if ($deleteById) {
                echo json_encode(['status' => '1']);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao localizar registro, tente novamente.']);
        }

        public function destroySelected() {


            if(!isset($_POST['ids'])) {
                echo json_encode(['status' => '0', 'msg' => 'O valor dos registros não são válidos, tente novamente.']);
                return;
            }

            $arrIds = explode(',', $_POST['ids']);

            $deleteSelected = $this->model->deleteSelected($arrIds);
            if ($deleteSelected) {
                echo json_encode(['status' => '1']);
                return;
            }

            echo json_encode(['status' => '0', 'msg' => 'Erro ao localizar registro, tente novamente.']);
        }
    }

    if (isLogged()) {
        // Pega a ação por get, verifica se existe o método no obj e caso não exista retorna erro
        $acao = (isset($_GET['acao'])) ? $_GET['acao'] : 'index';

        $obj = new PurchaseOrderController();
        if (method_exists($obj, $acao)) {
            $obj->$acao();
        } else {
            echo json_encode(['status' => '0', 'msg' => 'Não foi possível localizar a ação. Tente novamente']);
            return;
        }
    } else {
        echo json_encode(['status' => '2', 'msg' => 'Erro! Página restrita a usuários logados.']);
        return;
    }

?>