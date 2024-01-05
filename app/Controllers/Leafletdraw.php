<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TbldatapointModel;
use App\Models\TbldatalineModel;
use App\Models\TbldatapolyModel;

class Leafletdraw extends BaseController
{
    protected $TbldatapointModel;
    protected $TbldatalineModel;
    protected $TbldatapolyModel;
    public function __construct()
    {
        $this->TbldatapointModel = new TbldatapointModel();
        $this->TbldatalineModel = new TbldatalineModel();
        $this->TbldatapolyModel = new TbldatapolyModel();
    }

    public function index()
    {
        return view('leafletdraw/v_create');
    }

    public function simpan_point()
    {
        $data = [
            'nama' => $this->request->getPost('input_point_name'),
            'geom' => $this->request->getPost('input_point_geometry'),
        ];
        $this->TbldatapointModel->save($data);
        return redirect()->to('/');
    }
    public function simpan_polyline()
    {
        $data = [
            'nama' => $this->request->getPost('input_polyline_name'),
            'geom' => $this->request->getPost('input_polyline_geometry'),
        ];
        $this->TbldatalineModel->save($data);
        return redirect()->to('/');
    }
    public function simpan_polygon()
    {
        $data = [
            'nama' => $this->request->getPost('input_polygon_name'),
            'geom' => $this->request->getPost('input_polygon_geometry'),
        ];
        $this->TbldatapolyModel->save($data);
        return redirect()->to('/');
    }

    public function edit_point()
    {
        return view('leafletdraw/v_edit_point');
    }

    public function simpan_edit_point()
    {
        $id = (int)$this->request->getPost('id_point');
        $data = [
            'nama' => $this->request->getPost('edit_point_name'),
            'geom' => $this->request->getPost('edit_point_geometry'),
        ];

        $this->TbldatapointModel->update($id, $data);
        return redirect()->to('/editpoint');
    }
    public function edit_polyline()
    {
        return view('leafletdraw/v_edit_polyline');
    }

    public function simpan_edit_polyline()
    {
        $id = (int)$this->request->getPost('id_polyline');
        $data = [
            'nama' => $this->request->getPost('edit_polyline_name'),
            'geom' => $this->request->getPost('edit_polyline_geometry'),
        ];

        $this->TbldatalineModel->update($id, $data);
        return redirect()->to('/editpolyline');
    }

    public function edit_polygon()
    {
        return view('leafletdraw/v_edit_polygon');
    }
    public function simpan_edit_polygon()
    {
        $id = (int)$this->request->getPost('id_polygon');
        $data = [
            'nama' => $this->request->getPost('edit_polygon_name'),
            'geom' => $this->request->getPost('edit_polygon_geometry'),
        ];

        $this->TbldatapolyModel->update($id, $data);
        return redirect()->to('/editpolygon');
    }

    public function delete_point($id)
    {
        $this->TbldatapointModel->delete($id);
        return redirect()->to('/editpoint');
    }

    public function delete_polyline($id)
    {
        $this->TbldatalineModel->delete($id);
        return redirect()->to('/editpolyline');
    }

    public function delete_polygon($id)
    {
        $this->TbldatapolyModel->delete($id);
        return redirect()->to('/editpolygon');
    }
}
