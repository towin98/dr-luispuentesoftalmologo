<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormulaAnteojos extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    /**
     * Determines the prunable query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable(): Builder
    {
        return $this->where('deleted_at', '<=', now()->subWeek())->whereNotNull('deleted_at');
    }

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_paciente',
        'numero_formula_anteojos',
        'avs_sc_od',
        'avs_sc_oi',
        'avs_cc_od',
        'avs_cc_oi',
        'rx_od',
        'rx_oi',
        'adicion',
        'dp',
        'observacion',
        'ref_sub_od',
        'ref_sub_oi',
        'que_od',
        'que_oi',
        'hirschberg',
        'cover_test',
        'ppc',
        'motilidad_ocular',
        'papilas',
        'bio_od_par',
        'bio_od_ang',
        'bio_od_cri',
        'bio_od_con',
        'bio_od_iris',
        'bio_od_pro',
        'bio_od_cor',
        'bio_od_rpa',
        'bio_oi_par',
        'bio_oi_ang',
        'bio_oi_cri',
        'bio_oi_con',
        'bio_oi_iris',
        'bio_oi_pro',
        'bio_oi_cor',
        'bio_oi_rpa',
        'fon_od_pap',
        'fon_od_vit',
        'fon_od_mac',
        'fon_od_per',
        'fon_od_vre',
        'fon_od_retina',
        'fon_oi_pap',
        'fon_oi_vit',
        'fon_oi_mac',
        'fon_oi_per',
        'fon_oi_vre',
        'fon_oi_retina',
        'diagnostico',
        'tratamiento',
        'orden_medica',
        'observaciones2',
        'fecha_formula'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'id_paciente',
        'numero_formula_anteojos',
        'avs_sc_od',
        'avs_sc_oi',
        'avs_cc_od',
        'avs_cc_oi',
        'rx_od',
        'rx_oi',
        'adicion',
        'dp',
        'observacion',
        'ref_sub_od',
        'ref_sub_oi',
        'que_od',
        'que_oi',
        'hirschberg',
        'cover_test',
        'ppc',
        'motilidad_ocular',
        'papilas',
        'bio_od_par',
        'bio_od_ang',
        'bio_od_cri',
        'bio_od_con',
        'bio_od_iris',
        'bio_od_pro',
        'bio_od_cor',
        'bio_od_rpa',
        'bio_oi_par',
        'bio_oi_ang',
        'bio_oi_cri',
        'bio_oi_con',
        'bio_oi_iris',
        'bio_oi_pro',
        'bio_oi_cor',
        'bio_oi_rpa',
        'fon_od_pap',
        'fon_od_vit',
        'fon_od_mac',
        'fon_od_per',
        'fon_od_vre',
        'fon_od_retina',
        'fon_oi_pap',
        'fon_oi_vit',
        'fon_oi_mac',
        'fon_oi_per',
        'fon_oi_vre',
        'fon_oi_retina',
        'diagnostico',
        'tratamiento',
        'orden_medica',
        'observaciones2',
        'fecha_formula',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'     => 'El Numero de documento del paciente es requerido.',
        'numero_documento.integer'      => 'El Numero de documento del paciente debe ser un número entero.',
        'avs_sc_od.required'            => 'La Agudeza Visual sin corrección Ojo Derecho es requerida.',
        'avs_sc_od.string'              => 'La Agudeza Visual sin corrección Ojo Derecho debe ser un string.',
        'avs_sc_od.max'                 => 'La Agudeza Visual sin corrección Ojo Derecho es máximo 30 carácteres.',
        'avs_sc_oi.required'            => 'La Agudeza Visual sin corrección Ojo Izquierdo es requerida.',
        'avs_sc_oi.string'              => 'La Agudeza Visual sin corrección Ojo Izquierdo debe ser un string.',
        'avs_sc_oi.max'                 => 'La Agudeza Visual sin corrección Ojo Izquierdo es máximo 30 carácteres.',
        'avs_cc_od.required'            => 'La Agudeza Visual Con corrección Ojo Derecho es requerida.',
        'avs_cc_od.string'              => 'La Agudeza Visual Con corrección Ojo Derecho debe ser un string.',
        'avs_cc_od.max'                 => 'La Agudeza Visual Con corrección Ojo Derecho es máximo 30 carácteres.',
        'avs_cc_oi.required'            => 'La Agudeza Visual Con corrección Ojo Izquierdo es requerida.',
        'avs_cc_oi.string'              => 'La Agudeza Visual Con corrección Ojo Izquierdo debe ser un string.',
        'avs_cc_oi.max'                 => 'La Agudeza Visual Con corrección Ojo Izquierdo es máximo 30 carácteres.',
        'rx_od.required'                => 'El RX Ojo Derecho es requerido.',
        'rx_od.string'                  => 'El RX Ojo Derecho debe ser un string.',
        'rx_od.max'                     => 'El RX Ojo Derecho es máximo 30 carácteres.',
        'rx_oi.required'                => 'El RX Ojo Izquierdo es requerido.',
        'rx_oi.string'                  => 'El RX Ojo Izquierdo debe ser un string.',
        'rx_oi.max'                     => 'El RX Ojo Izquierdo es máximo 30 carácteres.',
        'adicion.required'              => 'La adicion es requerida.',
        'adicion.string'                => 'La adicion debe ser un string.',
        'adicion.max'                   => 'La adicion es máximo 30 carácteres.',
        'dp.required'                   => 'La Distancia Pupilar es requerida.',
        'dp.string'                     => 'La Distancia Pupilar debe ser un string.',
        'dp.max'                        => 'La Distancia Pupilar es máximo 30 carácteres.',
        'observacion.required'          => 'La Observacion es requerida.',
        'observacion.string'            => 'La Observacion debe ser un string.',
        // 'observacion.max'               => 'La Observacion es máximo 200 carácteres.',
        'ref_sub_od.required'           => 'La Refraccion Subjetiva Ojo Derecho es requerido.',
        'ref_sub_od.string'             => 'La Refraccion Subjetiva Ojo Derecho debe ser un string.',
        'ref_sub_od.max'                => 'La Refraccion Subjetiva Ojo Derecho es máximo 30 carácteres.',
        'ref_sub_oi.required'           => 'La Refraccion Subjetiva Ojo Izquierdo es requerido.',
        'ref_sub_oi.string'             => 'La Refraccion Subjetiva Ojo Izquierdo debe ser un string.',
        'ref_sub_oi.max'                => 'La Refraccion Subjetiva Ojo Izquierdo es máximo 30 carácteres.',
        'que_od.required'               => 'La Queratometría del Ojo Derecho es requerido.',
        'que_od.string'                 => 'La Queratometría del Ojo Derecho debe ser un string.',
        'que_od.max'                    => 'La Queratometría del Ojo Derecho es máximo 30 carácteres.',
        'que_oi.required'               => 'La Queratometría del Ojo Izquierdo es requerido.',
        'que_oi.string'                 => 'La Queratometría del Ojo Izquierdo debe ser un string.',
        'que_oi.max'                    => 'La Queratometría del Ojo Izquierdo es máximo 30 carácteres.',
        'hirschberg.required'           => 'El hirschberg es requerido.',
        'hirschberg.string'             => 'El hirschberg debe ser un string.',
        'hirschberg.max'                => 'El hirschberg es máximo 30 carácteres.',
        'cover_test.required'           => 'El Cover Test es requerido.',
        'cover_test.string'             => 'El Cover Test debe ser un string.',
        'cover_test.max'                => 'El Cover Test es máximo 30 carácteres.',
        'ppc.required'                  => 'El ppc (Punto Próximo de Convergencia) es requerido.',
        'ppc.string'                    => 'El ppc (Punto Próximo de Convergencia) debe ser un string.',
        'ppc.max'                       => 'El ppc (Punto Próximo de Convergencia) es máximo 30 carácteres.',
        'motilidad_ocular.required'     => 'La Motilidad Ocular es requerido.',
        'motilidad_ocular.string'       => 'La Motilidad Ocular debe ser un string.',
        'motilidad_ocular.max'          => 'La Motilidad Ocular es máximo 30 carácteres.',
        'papilas.required'              => 'Las Papilas es requerida.',
        'papilas.string'                => 'Las Papilas debe ser un string.',
        'papilas.max'                   => 'Las Papilas es máximo 30 carácteres.',
        // Biomicroscopia Ojo Derecho
        'bio_od_par.required'           => 'La Bio. O.D parpados es requerida.',
        'bio_od_par.string'             => 'La Bio. O.D parpados debe ser un string.',
        'bio_od_par.max'                => 'La Bio. O.D parpados es máximo 50 carácteres.',
        'bio_od_ang.required'           => 'La Bio. O.D ángulo es requerida.',
        'bio_od_ang.string'             => 'La Bio. O.D ángulo debe ser un string.',
        'bio_od_ang.max'                => 'La Bio. O.D ángulo es máximo 50 carácteres.',
        'bio_od_cri.required'           => 'La Bio. O.D cristalino es requerida.',
        'bio_od_cri.string'             => 'La Bio. O.D cristalino debe ser un string.',
        'bio_od_cri.max'                => 'La Bio. O.D cristalino es máximo 50 carácteres.',
        'bio_od_con.required'           => 'La Bio. O.D conjuntiva es requerida.',
        'bio_od_con.string'             => 'La Bio. O.D conjuntiva debe ser un string.',
        'bio_od_con.max'                => 'La Bio. O.D conjuntiva es máximo 50 carácteres.',
        'bio_od_iris.required'          => 'La Bio. O.D iris es requerida.',
        'bio_od_iris.string'            => 'La Bio. O.D iris debe ser un string.',
        'bio_od_iris.max'               => 'La Bio. O.D iris es máximo 50 carácteres.',
        'bio_od_pro.required'           => 'La Bio. O.D Presión Ocular es requerida.',
        'bio_od_pro.string'             => 'La Bio. O.D Presión Ocular debe ser un string.',
        'bio_od_pro.max'                => 'La Bio. O.D Presión Ocular es máximo 50 carácteres.',
        'bio_od_cor.required'           => 'La Bio. O.D Cornea es requerida.',
        'bio_od_cor.string'             => 'La Bio. O.D Cornea debe ser un string.',
        'bio_od_cor.max'                => 'La Bio. O.D Cornea es máximo 50 carácteres.',
        'bio_od_rpa.required'           => 'La Bio. O.D Reflejo Pupilar es requerida.',
        'bio_od_rpa.string'             => 'La Bio. O.D Reflejo Pupilar debe ser un string.',
        'bio_od_rpa.max'                => 'La Bio. O.D Reflejo Pupilar es máximo 50 carácteres.',
        'bio_od_dil.required'           => 'La Bio. O.D Dilatación es requerida.',
        'bio_od_dil.string'             => 'La Bio. O.D Dilatación debe ser un string.',
        'bio_od_dil.max'                => 'La Bio. O.D Dilatación es máximo 50 carácteres.',
        // Bio. Ojo Izquierdo
        'bio_oi_par.required'           => 'La Bio. O.I parpados es requerida.',
        'bio_oi_par.string'             => 'La Bio. O.I parpados debe ser un string.',
        'bio_oi_par.max'                => 'La Bio. O.I parpados es máximo 50 carácteres.',
        'bio_oi_ang.required'           => 'La Bio. O.I ángulo es requerida.',
        'bio_oi_ang.string'             => 'La Bio. O.I ángulo debe ser un string.',
        'bio_oi_ang.max'                => 'La Bio. O.I ángulo es máximo 50 carácteres.',
        'bio_oi_cri.required'           => 'La Bio. O.I cristalino es requerida.',
        'bio_oi_cri.string'             => 'La Bio. O.I cristalino debe ser un string.',
        'bio_oi_cri.max'                => 'La Bio. O.I cristalino es máximo 50 carácteres.',
        'bio_oi_con.required'           => 'La Bio. O.I conjuntiva es requerida.',
        'bio_oi_con.string'             => 'La Bio. O.I conjuntiva debe ser un string.',
        'bio_oi_con.max'                => 'La Bio. O.I conjuntiva es máximo 50 carácteres.',
        'bio_oi_iris.required'          => 'La Bio. O.I iris es requerida.',
        'bio_oi_iris.string'            => 'La Bio. O.I iris debe ser un string.',
        'bio_oi_iris.max'               => 'La Bio. O.I iris es máximo 50 carácteres.',
        'bio_oi_pro.required'           => 'La Bio. O.I Presión Ocular es requerida.',
        'bio_oi_pro.string'             => 'La Bio. O.I Presión Ocular debe ser un string.',
        'bio_oi_pro.max'                => 'La Bio. O.I Presión Ocular es máximo 50 carácteres.',
        'bio_oi_cor.required'           => 'La Bio. O.I Cornea es requerida.',
        'bio_oi_cor.string'             => 'La Bio. O.I Cornea debe ser un string.',
        'bio_oi_cor.max'                => 'La Bio. O.I Cornea es máximo 50 carácteres.',
        'bio_oi_rpa.required'           => 'La Bio. O.I Reflejo Pupilar es requerida.',
        'bio_oi_rpa.string'             => 'La Bio. O.I Reflejo Pupilar debe ser un string.',
        'bio_oi_rpa.max'                => 'La Bio. O.I Reflejo Pupilar es máximo 50 carácteres.',
        'bio_oi_dil.required'           => 'La Bio. O.I Dilatación es requerida.',
        'bio_oi_dil.string'             => 'La Bio. O.I Dilatación debe ser un string.',
        'bio_oi_dil.max'                => 'La Bio. O.I Dilatación es máximo 50 carácteres.',
        // Campos Fondo de Ojo ojo derecho
        'fon_od_pap.required'           => 'El Fondo del Ojo Derecho Papila es requerido.',
        'fon_od_pap.string'             => 'El Fondo del Ojo Derecho Papila debe ser un string.',
        'fon_od_pap.max'                => 'El Fondo del Ojo Derecho Papila es máximo 30 carácteres.',
        'fon_od_vit.required'           => 'El Fondo del Ojo Derecho Vitreo es requerido.',
        'fon_od_vit.string'             => 'El Fondo del Ojo Derecho Vitreo debe ser un string.',
        'fon_od_vit.max'                => 'El Fondo del Ojo Derecho Vitreo es máximo 30 carácteres.',
        'fon_od_mac.required'           => 'El Fondo del Ojo Derecho Macula es requerido.',
        'fon_od_mac.string'             => 'El Fondo del Ojo Derecho Macula debe ser un string.',
        'fon_od_mac.max'                => 'El Fondo del Ojo Derecho Macula es máximo 30 carácteres.',
        'fon_od_per.required'           => 'El Fondo del Ojo Derecho Periferia es requerido.',
        'fon_od_per.string'             => 'El Fondo del Ojo Derecho Periferia debe ser un string.',
        'fon_od_per.max'                => 'El Fondo del Ojo Derecho Periferia es máximo 30 carácteres.',
        'fon_od_vre.required'           => 'El Fondo del Ojo Derecho Vasos Retinales es requerido.',
        'fon_od_vre.string'             => 'El Fondo del Ojo Derecho Vasos Retinales debe ser un string.',
        'fon_od_vre.max'                => 'El Fondo del Ojo Derecho Vasos Retinales es máximo 30 carácteres.',
        'fon_od_retina.required'        => 'El Fondo del Ojo Derecho Retina es requerido.',
        'fon_od_retina.string'          => 'El Fondo del Ojo Derecho Retina debe ser un string.',
        'fon_od_retina.max'             => 'El Fondo del Ojo Derecho Retina es máximo 30 carácteres.',
        // Campos Fondo de Ojo ojo Izquierdo
        'fon_oi_pap.required'           => 'El Fondo del Ojo Izquierdo Papila es requerido.',
        'fon_oi_pap.string'             => 'El Fondo del Ojo Izquierdo Papila debe ser un string.',
        'fon_oi_pap.max'                => 'El Fondo del Ojo Izquierdo Papila es máximo 30 carácteres.',
        'fon_oi_vit.required'           => 'El Fondo del Ojo Izquierdo Vitreo es requerido.',
        'fon_oi_vit.string'             => 'El Fondo del Ojo Izquierdo Vitreo debe ser un string.',
        'fon_oi_vit.max'                => 'El Fondo del Ojo Izquierdo Vitreo es máximo 30 carácteres.',
        'fon_oi_mac.required'           => 'El Fondo del Ojo Izquierdo Macula es requerido.',
        'fon_oi_mac.string'             => 'El Fondo del Ojo Izquierdo Macula debe ser un string.',
        'fon_oi_mac.max'                => 'El Fondo del Ojo Izquierdo Macula es máximo 30 carácteres.',
        'fon_oi_per.required'           => 'El Fondo del Ojo Izquierdo Periferia es requerido.',
        'fon_oi_per.string'             => 'El Fondo del Ojo Izquierdo Periferia debe ser un string.',
        'fon_oi_per.max'                => 'El Fondo del Ojo Izquierdo Periferia es máximo 30 carácteres.',
        'fon_oi_vre.required'           => 'El Fondo del Ojo Izquierdo Vasos Retinales es requerido.',
        'fon_oi_vre.string'             => 'El Fondo del Ojo Izquierdo Vasos Retinales debe ser un string.',
        'fon_oi_vre.max'                => 'El Fondo del Ojo Izquierdo Vasos Retinales es máximo 30 carácteres.',
        'fon_oi_retina.required'        => 'El Fondo del Ojo Izquierdo Retina es requerido.',
        'fon_oi_retina.string'          => 'El Fondo del Ojo Izquierdo Retina debe ser un string.',
        'fon_oi_retina.max'             => 'El Fondo del Ojo Izquierdo Retina es máximo 30 carácteres.',
        'diagnostico.required'          => 'El Diagnostico es requerido.',
        'diagnostico.string'            => 'El Diagnostico debe ser un string.',
        // 'diagnostico.max'               => 'El Diagnostico es máximo 200 carácteres.',
        'tratamiento.required'          => 'El Tratamiento es requerido.',
        'tratamiento.string'            => 'El Tratamiento debe ser un string.',
        // 'tratamiento.max'               => 'El Tratamiento es máximo 200 carácteres.',
        'orden_medica.required'         => 'La Orden Medica es requerida.',
        'orden_medica.string'           => 'La Orden Medica debe ser un string.',
        // 'orden_medica.max'              => 'La Orden Medica es máximo 200 carácteres.',
        'observaciones2.required'       => 'El campo observaciones es requerida.',
        'observaciones2.string'         => 'El campo observaciones debe ser un string.',
        'fecha_formula.required'        => 'La fecha de la formula es requerida.',
        'fecha_formula.date_format'     => 'La fecha de formula debe ser ej: Y-m-d.',
    ];

    static $rulesStore = [
        'numero_documento'      => 'required|integer',
        'avs_sc_od'             => 'nullable|string|max:30',
        'avs_sc_oi'             => 'nullable|string|max:30',
        'avs_cc_od'             => 'nullable|string|max:30',
        'avs_cc_oi'             => 'nullable|string|max:30',
        'rx_od'                 => 'nullable|string|max:30',
        'rx_oi'                 => 'nullable|string|max:30',
        'adicion'               => 'nullable|string|max:30',
        'dp'                    => 'nullable|string|max:30',
        'observacion'           => 'nullable|string',
        'ref_sub_od'            => 'nullable|string|max:30',
        'ref_sub_oi'            => 'nullable|string|max:30',
        'que_od'                => 'nullable|string|max:30',
        'que_oi'                => 'nullable|string|max:30',
        'hirschberg'            => 'nullable|string|max:30',
        'cover_test'            => 'nullable|string|max:30',
        'ppc'                   => 'nullable|string|max:30',
        'motilidad_ocular'      => 'nullable|string|max:30',
        'papilas'               => 'nullable|string|max:30',
        'bio_od_par'            => 'nullable|string|max:50',
        'bio_od_ang'            => 'nullable|string|max:50',
        'bio_od_cri'            => 'nullable|string|max:50',
        'bio_od_con'            => 'nullable|string|max:50',
        'bio_od_iris'           => 'nullable|string|max:50',
        'bio_od_pro'            => 'nullable|string|max:50',
        'bio_od_cor'            => 'nullable|string|max:50',
        'bio_od_rpa'            => 'nullable|string|max:50',
        'bio_od_dil'            => 'nullable|string|max:50',
        'bio_oi_par'            => 'nullable|string|max:50',
        'bio_oi_ang'            => 'nullable|string|max:50',
        'bio_oi_cri'            => 'nullable|string|max:50',
        'bio_oi_con'            => 'nullable|string|max:50',
        'bio_oi_iris'           => 'nullable|string|max:50',
        'bio_oi_pro'            => 'nullable|string|max:50',
        'bio_oi_cor'            => 'nullable|string|max:50',
        'bio_oi_rpa'            => 'nullable|string|max:50',
        'bio_oi_dil'            => 'nullable|string|max:50',
        'fon_od_pap'            => 'nullable|string|max:30',
        'fon_od_vit'            => 'nullable|string|max:30',
        'fon_od_mac'            => 'nullable|string|max:30',
        'fon_od_per'            => 'nullable|string|max:30',
        'fon_od_vre'            => 'nullable|string|max:30',
        'fon_od_retina'         => 'nullable|string|max:30',
        'fon_oi_pap'            => 'nullable|string|max:30',
        'fon_oi_vit'            => 'nullable|string|max:30',
        'fon_oi_mac'            => 'nullable|string|max:30',
        'fon_oi_per'            => 'nullable|string|max:30',
        'fon_oi_vre'            => 'nullable|string|max:30',
        'fon_oi_retina'         => 'nullable|string|max:30',
        'diagnostico'           => 'nullable|string',
        'tratamiento'           => 'nullable|string',
        'orden_medica'          => 'nullable|string',
        'observaciones2'        => 'nullable|string',
        'fecha_formula'         => 'required|date_format:Y-m-d'
    ];

    /**
     * Scope para realizar una búsqueda mixta.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $buscar Valor a buscar
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscar($query, $buscar) {
        if($buscar){
            return $query->where('formula_anteojos.numero_formula_anteojos', 'like', '%'.trim($buscar).'%')
                        ->orWhere('formula_anteojos.fecha_formula', 'like', '%'.trim($buscar).'%')
                        ->orWhere('formula_anteojos.updated_at', 'like', '%'.trim($buscar).'%')
                        ->orWhereHas('getPaciente', function($queryHas) use ($buscar) {
                            $queryHas->where('numero_documento', 'LIKE', "%".trim($buscar)."%")
                                    ->orWhere('nombre', 'LIKE', "%".trim($buscar)."%")
                                    ->orWhere('apellido', 'LIKE', "%".trim($buscar)."%");
                        });
        }
    }

    /**
     * Scope para ordenar una lista.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $columna Nombnre de la columna de la tabla
     * @param mixed $orden Tipo de ordenamiento ASC|DESC
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdenamiento($query, $columna, $orden){
        if ($columna && $orden) {
            if (strtolower($orden) != "desc" && strtolower($orden) != "asc") {
                $orden = "desc";
            }
            switch ($columna) {
                case 'numero_formula_anteojos':
                case 'fecha_formula':
                case 'updated_at':
                    return $query->orderBy($columna, $orden);
                break;
                case 'numero_documento':
                case 'nombre':
                case 'apellido':
                    return $query->leftJoin('paciente as paciente', 'paciente.id', '=', 'formula_anteojos.id_paciente')
                        ->orderBy("paciente.$columna", $orden);
                break;
            }
        }
    }

    /**
     * Obtiene el registro paciente asociado a formula anteojos - Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'id_paciente', 'id');
    }
}
