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
        'avsc_od',
        'avsc_oi',
        'rx_od',
        'rx_oi',
        'ref_obj_od',
        'ref_obj_oi',
        'ref_sub_od',
        'ref_sub_oi',
        'que_od',
        'que_oi',
        'hirschberg',
        'cover_test',
        'ppc',
        'motilidad_ocular',
        'dilatacion_pupilar',
        'pupilas',
        'bio_od_par',
        'bio_od_gra',
        'bio_od_cri',
        'bio_od_con',
        'bio_od_iris',
        'bio_od_pre',
        'bio_od_cor',
        'bio_od_ref',
        'bio_od_ocu',
        'bio_od_pup',
        'bio_oi_par',
        'bio_oi_gra',
        'bio_oi_cri',
        'bio_oi_con',
        'bio_oi_iris',
        'bio_oi_pre',
        'bio_oi_cor',
        'bio_oi_ref',
        'bio_oi_ocu',
        'bio_oi_pup',
        'fon_od_pap',
        'fon_od_vit',
        'fon_od_mac',
        'fon_od_per',
        'fon_od_vas',
        'fon_od_retina',
        'fon_od_retinales',
        'fon_oi_pap',
        'fon_oi_vit',
        'fon_oi_mac',
        'fon_oi_per',
        'fon_oi_vas',
        'fon_oi_retina',
        'fon_oi_retinales',
        'diagnostico',
        'tratamiento',
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
        'avsc_od',
        'avsc_oi',
        'rx_od',
        'rx_oi',
        'ref_obj_od',
        'ref_obj_oi',
        'ref_sub_od',
        'ref_sub_oi',
        'que_od',
        'que_oi',
        'hirschberg',
        'cover_test',
        'ppc',
        'motilidad_ocular',
        'dilatacion_pupilar',
        'pupilas',
        'bio_od_par',
        'bio_od_gra',
        'bio_od_cri',
        'bio_od_con',
        'bio_od_iris',
        'bio_od_pre',
        'bio_od_cor',
        'bio_od_ref',
        'bio_od_ocu',
        'bio_od_pup',
        'bio_oi_par',
        'bio_oi_gra',
        'bio_oi_cri',
        'bio_oi_con',
        'bio_oi_iris',
        'bio_oi_pre',
        'bio_oi_cor',
        'bio_oi_ref',
        'bio_oi_ocu',
        'bio_oi_pup',
        'fon_od_pap',
        'fon_od_vit',
        'fon_od_mac',
        'fon_od_per',
        'fon_od_vas',
        'fon_od_retina',
        'fon_od_retinales',
        'fon_oi_pap',
        'fon_oi_vit',
        'fon_oi_mac',
        'fon_oi_per',
        'fon_oi_vas',
        'fon_oi_retina',
        'fon_oi_retinales',
        'diagnostico',
        'tratamiento',
        'fecha_formula',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'     => 'El Numero de documento del paciente es requerido.',
        'numero_documento.integer'      => 'El Numero de documento del paciente debe ser un número entero.',
        'avsc_od.required'              => 'La AVSC (Agudeza Visual sin corrección) Ojo Derecho es requerida.',
        'avsc_od.string'                => 'La AVSC (Agudeza Visual sin corrección) Ojo Derecho debe ser un string.',
        'avsc_od.max'                   => 'La AVSC (Agudeza Visual sin corrección) Ojo Derecho es máximo 25 carácteres.',
        'avsc_oi.required'              => 'La AVSC (Agudeza Visual sin corrección) Ojo Izquierdo es requerida.',
        'avsc_oi.string'                => 'La AVSC (Agudeza Visual sin corrección) Ojo Izquierdo debe ser un string.',
        'avsc_oi.max'                   => 'La AVSC (Agudeza Visual sin corrección) Ojo Izquierdo es máximo 25 carácteres.',
        'rx_od.required'                => 'El RX Ojo Derecho es requerido.',
        'rx_od.string'                  => 'El RX Ojo Derecho debe ser un string.',
        'rx_od.max'                     => 'El RX Ojo Derecho es máximo 25 carácteres.',
        'rx_oi.required'                => 'El RX Ojo Izquierdo es requerido.',
        'rx_oi.string'                  => 'El RX Ojo Izquierdo debe ser un string.',
        'rx_oi.max'                     => 'El RX Ojo Izquierdo es máximo 25 carácteres.',
        'ref_obj_od.required'           => 'La Refraccion Objetiva Ojo Derecho es requerido.',
        'ref_obj_od.string'             => 'La Refraccion Objetiva Ojo Derecho debe ser un string.',
        'ref_obj_od.max'                => 'La Refraccion Objetiva Ojo Derecho es máximo 25 carácteres.',
        'ref_obj_oi.required'           => 'La Refraccion Objetiva Ojo Izquierdo es requerido.',
        'ref_obj_oi.string'             => 'La Refraccion Objetiva Ojo Izquierdo debe ser un string.',
        'ref_obj_oi.max'                => 'La Refraccion Objetiva Ojo Izquierdo es máximo 25 carácteres.',
        'ref_sub_od.required'           => 'La Refraccion Subjetiva Ojo Derecho es requerido.',
        'ref_sub_od.string'             => 'La Refraccion Subjetiva Ojo Derecho debe ser un string.',
        'ref_sub_od.max'                => 'La Refraccion Subjetiva Ojo Derecho es máximo 25 carácteres.',
        'ref_sub_oi.required'           => 'La Refraccion Objetiva Ojo Izquierdo es requerido.',
        'ref_sub_oi.string'             => 'La Refraccion Objetiva Ojo Izquierdo debe ser un string.',
        'ref_sub_oi.max'                => 'La Refraccion Objetiva Ojo Izquierdo es máximo 25 carácteres.',
        'que_od.required'               => 'La Queratometría del Ojo Derecho es requerido.',
        'que_od.string'                 => 'La Queratometría del Ojo Derecho debe ser un string.',
        'que_od.max'                    => 'La Queratometría del Ojo Derecho es máximo 25 carácteres.',
        'que_oi.required'               => 'La Queratometría del Ojo Izquierdo es requerido.',
        'que_oi.string'                 => 'La Queratometría del Ojo Izquierdo debe ser un string.',
        'que_oi.max'                    => 'La Queratometría del Ojo Izquierdo es máximo 25 carácteres.',
        'hirschberg.required'           => 'El hirschberg es requerido.',
        'hirschberg.string'             => 'El hirschberg debe ser un string.',
        'hirschberg.max'                => 'El hirschberg es máximo 25 carácteres.',
        'cover_test.required'           => 'El Cover Test es requerido.',
        'cover_test.string'             => 'El Cover Test debe ser un string.',
        'cover_test.max'                => 'El Cover Test es máximo 25 carácteres.',
        'ppc.required'                  => 'El ppc (Punto Próximo de Convergencia) es requerido.',
        'ppc.string'                    => 'El ppc (Punto Próximo de Convergencia) debe ser un string.',
        'ppc.max'                       => 'El ppc (Punto Próximo de Convergencia) es máximo 25 carácteres.',
        'motilidad_ocular.required'     => 'La Motilidad Ocular es requerido.',
        'motilidad_ocular.string'       => 'La Motilidad Ocular debe ser un string.',
        'motilidad_ocular.max'          => 'La Motilidad Ocular es máximo 25 carácteres.',
        'dilatacion_pupilar.required'   => 'La Dilatacion Pupilar es requerida.',
        'dilatacion_pupilar.string'     => 'La Dilatacion Pupilar debe ser un string.',
        'dilatacion_pupilar.max'        => 'La Dilatacion Pupilar es máximo 25 carácteres.',
        'pupilas.required'              => 'Las Pupilas es requerida.',
        'pupilas.string'                => 'Las Pupilas debe ser un string.',
        'pupilas.max'                   => 'Las Pupilas es máximo 25 carácteres.',
        // Biomicroscopia Ojo Derecho
        'bio_od_par.required'           => 'La Bio. O.D parpados es requerida.',
        'bio_od_par.string'             => 'La Bio. O.D parpados debe ser un string.',
        'bio_od_par.max'                => 'La Bio. O.D parpados es máximo 25 carácteres.',
        'bio_od_gra.required'           => 'La Bio. O.D grado es requerida.',
        'bio_od_gra.string'             => 'La Bio. O.D grado debe ser un string.',
        'bio_od_gra.max'                => 'La Bio. O.D grado es máximo 25 carácteres.',
        'bio_od_cri.required'           => 'La Bio. O.D cristalino es requerida.',
        'bio_od_cri.string'             => 'La Bio. O.D cristalino debe ser un string.',
        'bio_od_cri.max'                => 'La Bio. O.D cristalino es máximo 25 carácteres.',
        'bio_od_con.required'           => 'La Bio. O.D conjuntiva es requerida.',
        'bio_od_con.string'             => 'La Bio. O.D conjuntiva debe ser un string.',
        'bio_od_con.max'                => 'La Bio. O.D conjuntiva es máximo 25 carácteres.',
        'bio_od_iris.required'          => 'La Bio. O.D iris es requerida.',
        'bio_od_iris.string'            => 'La Bio. O.D iris debe ser un string.',
        'bio_od_iris.max'               => 'La Bio. O.D iris es máximo 25 carácteres.',
        'bio_od_pre.required'           => 'La Bio. O.D Presión es requerida.',
        'bio_od_pre.string'             => 'La Bio. O.D Presión debe ser un string.',
        'bio_od_pre.max'                => 'La Bio. O.D Presión es máximo 25 carácteres.',
        'bio_od_cor.required'           => 'La Bio. O.D Cornea es requerida.',
        'bio_od_cor.string'             => 'La Bio. O.D Cornea debe ser un string.',
        'bio_od_cor.max'                => 'La Bio. O.D Cornea es máximo 25 carácteres.',
        'bio_od_ref.required'           => 'La Bio. O.D Reflejo es requerida.',
        'bio_od_ref.string'             => 'La Bio. O.D Reflejo debe ser un string.',
        'bio_od_ref.max'                => 'La Bio. O.D Reflejo es máximo 25 carácteres.',
        'bio_od_ocu.required'           => 'La Bio. O.D Ocular es requerida.',
        'bio_od_ocu.string'             => 'La Bio. O.D Ocular debe ser un string.',
        'bio_od_ocu.max'                => 'La Bio. O.D Ocular es máximo 25 carácteres.',
        'bio_od_pup.required'           => 'La Bio. O.D Pupilar es requerida.',
        'bio_od_pup.string'             => 'La Bio. O.D Pupilar debe ser un string.',
        'bio_od_pup.max'                => 'La Bio. O.D Pupilar es máximo 25 carácteres.',
        // Bio. Ojo Izquierdo
        'bio_oi_par.required'           => 'La Bio. O.I parpados es requerida.',
        'bio_oi_par.string'             => 'La Bio. O.I parpados debe ser un string.',
        'bio_oi_par.max'                => 'La Bio. O.I parpados es máximo 25 carácteres.',
        'bio_oi_gra.required'           => 'La Bio. O.I grado es requerida.',
        'bio_oi_gra.string'             => 'La Bio. O.I grado debe ser un string.',
        'bio_oi_gra.max'                => 'La Bio. O.I grado es máximo 25 carácteres.',
        'bio_oi_cri.required'           => 'La Bio. O.I cristalino es requerida.',
        'bio_oi_cri.string'             => 'La Bio. O.I cristalino debe ser un string.',
        'bio_oi_cri.max'                => 'La Bio. O.I cristalino es máximo 25 carácteres.',
        'bio_oi_con.required'           => 'La Bio. O.I conjuntiva es requerida.',
        'bio_oi_con.string'             => 'La Bio. O.I conjuntiva debe ser un string.',
        'bio_oi_con.max'                => 'La Bio. O.I conjuntiva es máximo 25 carácteres.',
        'bio_oi_iris.required'          => 'La Bio. O.I iris es requerida.',
        'bio_oi_iris.string'            => 'La Bio. O.I iris debe ser un string.',
        'bio_oi_iris.max'               => 'La Bio. O.I iris es máximo 25 carácteres.',
        'bio_oi_pre.required'           => 'La Bio. O.I Presión es requerida.',
        'bio_oi_pre.string'             => 'La Bio. O.I Presión debe ser un string.',
        'bio_oi_pre.max'                => 'La Bio. O.I Presión es máximo 25 carácteres.',
        'bio_oi_cor.required'           => 'La Bio. O.I Cornea es requerida.',
        'bio_oi_cor.string'             => 'La Bio. O.I Cornea debe ser un string.',
        'bio_oi_cor.max'                => 'La Bio. O.I Cornea es máximo 25 carácteres.',
        'bio_oi_ref.required'           => 'La Bio. O.I Reflejo es requerida.',
        'bio_oi_ref.string'             => 'La Bio. O.I Reflejo debe ser un string.',
        'bio_oi_ref.max'                => 'La Bio. O.I Reflejo es máximo 25 carácteres.',
        'bio_oi_ocu.required'           => 'La Bio. O.I Ocular es requerida.',
        'bio_oi_ocu.string'             => 'La Bio. O.I Ocular debe ser un string.',
        'bio_oi_ocu.max'                => 'La Bio. O.I Ocular es máximo 25 carácteres.',
        'bio_oi_pup.required'           => 'La Bio. O.I Pupilar es requerida.',
        'bio_oi_pup.string'             => 'La Bio. O.I Pupilar debe ser un string.',
        'bio_oi_pup.max'                => 'La Bio. O.I Pupilar es máximo 25 carácteres.',
        // Campos Fondo de Ojo ojo derecho
        'fon_od_pap.required'           => 'El Fondo del Ojo Derecho Papila es requerido.',
        'fon_od_pap.string'             => 'El Fondo del Ojo Derecho Papila debe ser un string.',
        'fon_od_pap.max'                => 'El Fondo del Ojo Derecho Papila es máximo 25 carácteres.',
        'fon_od_vit.required'           => 'El Fondo del Ojo Derecho Vitreo es requerido.',
        'fon_od_vit.string'             => 'El Fondo del Ojo Derecho Vitreo debe ser un string.',
        'fon_od_vit.max'                => 'El Fondo del Ojo Derecho Vitreo es máximo 25 carácteres.',
        'fon_od_mac.required'           => 'El Fondo del Ojo Derecho Macula es requerido.',
        'fon_od_mac.string'             => 'El Fondo del Ojo Derecho Macula debe ser un string.',
        'fon_od_mac.max'                => 'El Fondo del Ojo Derecho Macula es máximo 25 carácteres.',
        'fon_od_per.required'           => 'El Fondo del Ojo Derecho Periferia es requerido.',
        'fon_od_per.string'             => 'El Fondo del Ojo Derecho Periferia debe ser un string.',
        'fon_od_per.max'                => 'El Fondo del Ojo Derecho Periferia es máximo 25 carácteres.',
        'fon_od_vas.required'           => 'El Fondo del Ojo Derecho Vasos es requerido.',
        'fon_od_vas.string'             => 'El Fondo del Ojo Derecho Vasos debe ser un string.',
        'fon_od_vas.max'                => 'El Fondo del Ojo Derecho Vasos es máximo 25 carácteres.',
        'fon_od_retina.required'        => 'El Fondo del Ojo Derecho Retina es requerido.',
        'fon_od_retina.string'          => 'El Fondo del Ojo Derecho Retina debe ser un string.',
        'fon_od_retina.max'             => 'El Fondo del Ojo Derecho Retina es máximo 25 carácteres.',
        'fon_od_retinales.required'     => 'El Fondo del Ojo Derecho Retinales es requerido.',
        'fon_od_retinales.string'       => 'El Fondo del Ojo Derecho Retinales debe ser un string.',
        'fon_od_retinales.max'          => 'El Fondo del Ojo Derecho Retinales es máximo 25 carácteres.',
        // Campos Fondo de Ojo ojo Izquierdo
        'fon_oi_pap.required'           => 'El Fondo del Ojo Izquierdo Papila es requerido.',
        'fon_oi_pap.string'             => 'El Fondo del Ojo Izquierdo Papila debe ser un string.',
        'fon_oi_pap.max'                => 'El Fondo del Ojo Izquierdo Papila es máximo 25 carácteres.',
        'fon_oi_vit.required'           => 'El Fondo del Ojo Izquierdo Vitreo es requerido.',
        'fon_oi_vit.string'             => 'El Fondo del Ojo Izquierdo Vitreo debe ser un string.',
        'fon_oi_vit.max'                => 'El Fondo del Ojo Izquierdo Vitreo es máximo 25 carácteres.',
        'fon_oi_mac.required'           => 'El Fondo del Ojo Izquierdo Macula es requerido.',
        'fon_oi_mac.string'             => 'El Fondo del Ojo Izquierdo Macula debe ser un string.',
        'fon_oi_mac.max'                => 'El Fondo del Ojo Izquierdo Macula es máximo 25 carácteres.',
        'fon_oi_per.required'           => 'El Fondo del Ojo Izquierdo Periferia es requerido.',
        'fon_oi_per.string'             => 'El Fondo del Ojo Izquierdo Periferia debe ser un string.',
        'fon_oi_per.max'                => 'El Fondo del Ojo Izquierdo Periferia es máximo 25 carácteres.',
        'fon_oi_vas.required'           => 'El Fondo del Ojo Izquierdo Vasos es requerido.',
        'fon_oi_vas.string'             => 'El Fondo del Ojo Izquierdo Vasos debe ser un string.',
        'fon_oi_vas.max'                => 'El Fondo del Ojo Izquierdo Vasos es máximo 25 carácteres.',
        'fon_oi_retina.required'        => 'El Fondo del Ojo Izquierdo Retina es requerido.',
        'fon_oi_retina.string'          => 'El Fondo del Ojo Izquierdo Retina debe ser un string.',
        'fon_oi_retina.max'             => 'El Fondo del Ojo Izquierdo Retina es máximo 25 carácteres.',
        'fon_oi_retinales.required'     => 'El Fondo del Ojo Izquierdo Retinales es requerido.',
        'fon_oi_retinales.string'       => 'El Fondo del Ojo Izquierdo Retinales debe ser un string.',
        'fon_oi_retinales.max'          => 'El Fondo del Ojo Izquierdo Retinales es máximo 25 carácteres.',
        'diagnostico.required'          => 'El Diagnostico es requerido.',
        'diagnostico.string'            => 'El Diagnostico debe ser un string.',
        'tratamiento.required'          => 'El Tratamiento es requerido.',
        'tratamiento.string'            => 'El Tratamiento debe ser un string.',
        'fecha_formula.required'        => 'La fecha de la formula es requerida.',
        'fecha_formula.date_format'     => 'La fecha de formula debe ser ej: Y-m-d.',
    ];

    static $rulesStore = [
        'numero_documento'       => 'required|integer',
        'avsc_od'               => 'required|string|max:25',
        'avsc_oi'               => 'required|string|max:25',
        'rx_od'                 => 'required|string|max:25',
        'rx_oi'                 => 'required|string|max:25',
        'ref_obj_od'            => 'required|string|max:25',
        'ref_obj_oi'            => 'required|string|max:25',
        'ref_sub_od'            => 'required|string|max:25',
        'ref_sub_oi'            => 'required|string|max:25',
        'que_od'                => 'required|string|max:25',
        'que_oi'                => 'required|string|max:25',
        'hirschberg'            => 'required|string|max:25',
        'cover_test'            => 'required|string|max:25',
        'ppc'                   => 'required|string|max:25',
        'motilidad_ocular'      => 'required|string|max:25',
        'dilatacion_pupilar'    => 'required|string|max:25',
        'pupilas'               => 'required|string|max:25',
        'bio_od_par'            => 'required|string|max:25',
        'bio_od_gra'            => 'required|string|max:25',
        'bio_od_cri'            => 'required|string|max:25',
        'bio_od_con'            => 'required|string|max:25',
        'bio_od_iris'           => 'required|string|max:25',
        'bio_od_pre'            => 'required|string|max:25',
        'bio_od_cor'            => 'required|string|max:25',
        'bio_od_ref'            => 'required|string|max:25',
        'bio_od_ocu'            => 'required|string|max:25',
        'bio_od_pup'            => 'required|string|max:25',
        'bio_oi_par'            => 'required|string|max:25',
        'bio_oi_gra'            => 'required|string|max:25',
        'bio_oi_cri'            => 'required|string|max:25',
        'bio_oi_con'            => 'required|string|max:25',
        'bio_oi_iris'           => 'required|string|max:25',
        'bio_oi_pre'            => 'required|string|max:25',
        'bio_oi_cor'            => 'required|string|max:25',
        'bio_oi_ref'            => 'required|string|max:25',
        'bio_oi_ocu'            => 'required|string|max:25',
        'bio_oi_pup'            => 'required|string|max:25',
        'fon_od_pap'            => 'required|string|max:25',
        'fon_od_vit'            => 'required|string|max:25',
        'fon_od_mac'            => 'required|string|max:25',
        'fon_od_per'            => 'required|string|max:25',
        'fon_od_vas'            => 'required|string|max:25',
        'fon_od_retina'         => 'required|string|max:25',
        'fon_od_retinales'      => 'required|string|max:25',
        'fon_oi_pap'            => 'required|string|max:25',
        'fon_oi_vit'            => 'required|string|max:25',
        'fon_oi_mac'            => 'required|string|max:25',
        'fon_oi_per'            => 'required|string|max:25',
        'fon_oi_vas'            => 'required|string|max:25',
        'fon_oi_retina'         => 'required|string|max:25',
        'fon_oi_retinales'      => 'required|string|max:25',
        'diagnostico'           => 'required|string',
        'tratamiento'           => 'required|string',
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
