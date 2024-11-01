<?php

namespace Classes;

class Paginacion {
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;
    public $query; // Añadimos una nueva propiedad para la query

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0, $query = '') {
        $this->pagina_actual = (int)$pagina_actual;
        $this->registros_por_pagina = (int)$registros_por_pagina;
        $this->total_registros = (int)$total_registros;
        $this->query = $query;
    }

    public function offset() {
        $offset = $this->registros_por_pagina * ($this->pagina_actual - 1);
        return ($offset < 0) ? 0 : $offset;
    }

    public function total_paginas() {
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_anterior() {
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function pagina_siguiente() {
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_anterior() {
        $html = '';
        $queryPart = $this->query ? "&query={$this->query}" : '';
        if ($this->pagina_anterior()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}{$queryPart}\">&laquo Anterior</a>";
        }
        return $html;
    }

    public function enlace_siguiente() {
        $html = '';
        $queryPart = $this->query ? "&query={$this->query}" : '';
        if ($this->pagina_siguiente()) {
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}{$queryPart}\">Siguiente &raquo</a>";
        }
        return $html;
    }

    public function numeros_paginas() {
        $html = '';
        $page = $this->pagina_actual;
        $total_page = $this->total_paginas();
        $primera = ($page - 2) > 1 ? $page - 2 : 1;
        $ultima = ($page + 2) < $total_page ? $page + 2 : $total_page;
        $queryPart = $this->query ? "&query={$this->query}" : '';
        for ($i = $primera; $i <= $ultima; $i++) {
            if ($i === $page) {
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            } else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}{$queryPart}\">{$i}</a>";
            }
        }
        return $html;
    }

    public function paginacion() {
        $html = '';
        if ($this->total_registros > 1) {
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }
        return $html;
    }
}
