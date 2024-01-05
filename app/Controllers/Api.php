<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Tabeldatalokasiobjek;

class Api extends ResourceController
{
    protected $tabeldatalokasiobjek;

    public function __construct()
    {
        $this->tabeldatalokasiobjek = new Tabeldatalokasiobjek();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataobjek = $this->tabeldatalokasiobjek->findAll();

        $feature = array();

        foreach ($dataobjek as $d) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        floatval($d['longitude']),
                        floatval($d['latitude']),
                    ]
                ],
                'properties' => [
                    'id' => $d['id'],
                    'nama' => $d['nama'],
                    'deskripsi' => $d['deskripsi'],
                    'foto' => $d['foto'],
                ]
            ];
        }

        $geojson = array(
            'type'      => 'FeatureCollection',
            'features'  => $feature
        );

        return $this->respond($geojson);
    }

    public function point()
    {
        $db = db_connect();
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom, nama, deskripsi, foto, created_at, updated_at FROM tbl_data_point");
        $query_array = $query->getResultArray();
        $feature = array();
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }
    public function polyline()
    {
        $db = db_connect();
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom,
            ST_Length(ST_Transform(ST_SetSRID(ST_AsText(geom),4326),32749)) AS panjang,
            nama, deskripsi, foto, created_at, updated_at FROM tbl_data_line");
        $query_array = $query->getResultArray();
        $feature = array();
        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'panjang' => $q['panjang'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }
    public function polygon()
    {
        $db = db_connect();
        $query = $db->query("SELECT id, ST_AsGeoJSON(geom) AS geom, 
                    ST_Area(ST_Transform(ST_SetSRID(ST_AsText(geom),4326),32748)) AS area,
                    nama, deskripsi, foto, created_at, updated_at FROM tbl_data_area");
        $query_array = $query->getResultArray();
        $feature = array();

        foreach ($query_array as $q) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($q['geom']),
                'properties' => [
                    'id' => $q['id'],
                    'area' => $q['area'],
                    'nama' => $q['nama'],
                    'deskripsi' => $q['deskripsi'],
                    'foto' => $q['foto'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                ]
            ];
        }
        $geojson = array(
            'type' => 'FeatureCollection',
            'features' => $feature
        );
        // header allow origin
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        return $this->respond($geojson);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
