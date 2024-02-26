<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyTableSeeder extends Seeder
{
    public function run()
    {
        $families = [
            ['nombre' => 'Todas', 'slug' => 'todas', 'orden' => 28, 'import_file' => 'uploads/templateUpload/templateDefault.xlsx', 'active' => true],
            ['nombre' => 'BATERIA', 'slug' => 'bateria-1', 'orden' => 0, 'import_file' => 'uploads/templateUpload/templateBaterias.xlsx', 'active' => true],
            ['nombre' => 'CASCO', 'slug' => 'casco-1', 'orden' => 2, 'import_file' => 'uploads/templateUpload/templateCascos.xlsx', 'active' => true],
            ['nombre' => 'CAMARA', 'slug' => 'camara-1', 'orden' => 15, 'import_file' => 'uploads/templateUpload/templateCamaras.xlsx', 'active' => true],
            ['nombre' => 'CADENA', 'slug' => 'cadena', 'orden' => 16, 'import_file' => 'uploads/templateUpload/templateCadenas.xlsx', 'active' => true],
            ['nombre' => 'KIT TRASMISION', 'slug' => 'kit-trasmision', 'orden' => 3, 'import_file' => 'uploads/templateUpload/templateKitTransmision.xlsx', 'active' => true],
            ['nombre' => 'INDUMENTARIA', 'slug' => 'indumentaria-1', 'orden' => 17, 'import_file' => null, 'active' => true],
            ['nombre' => 'VISOR', 'slug' => 'visor-1', 'orden' => 18, 'import_file' => null, 'active' => true],
            ['nombre' => 'CUBIERTA MOTO', 'slug' => 'cubierta-moto-1', 'orden' => 1, 'import_file' => 'uploads/templateUpload/templateCubiertas.xlsx', 'active' => true],
            ['nombre' => 'CUBIERTA ATV', 'slug' => 'cubierta-atv-1', 'orden' => 19, 'import_file' => null, 'active' => true],
            ['nombre' => 'TRABA ANTIROBO', 'slug' => 'traba-antirobo', 'orden' => 21, 'import_file' => null, 'active' => true],
            ['nombre' => 'LUBRICANTE', 'slug' => 'lubricante-1', 'orden' => 22, 'import_file' => null, 'active' => true],
            ['nombre' => 'GUANTES', 'slug' => 'guantes-1', 'orden' => 23, 'import_file' => 'uploads/templateUpload/templateGuantes.xlsx', 'active' => true],
            ['nombre' => 'INDUMENTARIA DE LLUVIA', 'slug' => 'indumentaria-de-lluvia', 'orden' => 24, 'import_file' => 'uploads/templateUpload/templateIndumentariaDeLluvia.xlsx', 'active' => true],
            ['nombre' => 'UNION DE CADENA', 'slug' => 'union-de-cadena-1', 'orden' => 25, 'import_file' => null, 'active' => true],
            ['nombre' => 'DESARMADOR Y REMACHADOR', 'slug' => 'desarmador-y-remachador', 'orden' => 26, 'import_file' => null, 'active' => true],
            ['nombre' => 'CORONA', 'slug' => 'corona-1', 'orden' => 27, 'import_file' => null, 'active' => true],
            ['nombre' => 'PIÑON', 'slug' => 'piñon-1', 'orden' => 20, 'import_file' => null, 'active' => true],
            ['nombre' => 'BUJIA', 'slug' => 'bujia-1', 'orden' => 14, 'import_file' => null, 'active' => true],
            ['nombre' => 'CAPUCHON DE BUJIA', 'slug' => 'capuchon-de-bujia', 'orden' => 13, 'import_file' => null, 'active' => true],
            ['nombre' => 'Repuestos Plásticos', 'slug' => 'repuestos-plasticos', 'orden' => 12, 'import_file' => 'uploads/templateUpload/templateRepuestosPlasticos.xlsx', 'active' => true],
            ['nombre' => 'Repuestos Metal', 'slug' => 'repuestos-metal', 'orden' => 11, 'import_file' => 'uploads/templateUpload/templateRepuestosMetal.xlsx', 'active' => true],
            ['nombre' => 'BAUL', 'slug' => 'baul-1', 'orden' => 10, 'import_file' => null, 'active' => true],
            ['nombre' => 'ESCAPE', 'slug' => 'escape', 'orden' => 9, 'import_file' => 'uploads/templateUpload/templateEscapes.xlsx', 'active' => true],
            ['nombre' => 'PUNTERA DE ESCAPE', 'slug' => 'puntera-de-escape', 'orden' => 8, 'import_file' => 'uploads/templateUpload/templatePunteraEscapes.xlsx', 'active' => true],
            ['nombre' => 'CURVA DE SALIDA', 'slug' => 'curva-de-salida', 'orden' => 7, 'import_file' => 'uploads/templateUpload/templateCurvaDeSalida.xlsx', 'active' => true],
            ['nombre' => 'BOTAS', 'slug' => 'botas-1', 'orden' => 6, 'import_file' => 'uploads/templateUpload/templateBotas.xlsx', 'active' => true],
            ['nombre' => 'ZAPATA DE FRENO', 'slug' => 'zapata-de-freno', 'orden' => 5, 'import_file' => 'uploads/templateUpload/templateZapataDeFreno.xlsx', 'active' => true],
            ['nombre' => 'PASTILLA DE FRENO', 'slug' => 'pastilla-de-freno', 'orden' => 4, 'import_file' => 'uploads/templateUpload/templatePastillaDeFreno.xlsx', 'active' => true],
            ['nombre' => 'FILTRO DE AIRE', 'slug' => 'filtro-de-aire', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'FILTRO DE ACEITE', 'slug' => 'filtro-de-aceite', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'LIQUIDO DE FRENO', 'slug' => 'liquido-de-freno', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'BIDON', 'slug' => 'bidon-1', 'orden' => 0, 'import_file' => null, 'active' => true],
            ['nombre' => 'DISCO DE FRENO', 'slug' => 'disco-de-freno-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'BLOQUEADOR DE SUSPENSION', 'slug' => 'bloqueador-de-suspension', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'TAPON DE ESCAPE', 'slug' => 'tapon-de-escape', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'ARO DE LLANTA', 'slug' => 'aro-de-llanta-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'PORTA EQUIPAJE', 'slug' => 'porta-equipaje-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'CABALETE', 'slug' => 'cabalete', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'MANUBRIO', 'slug' => 'manubrio-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'PEDAL DE FRENO', 'slug' => 'pedal-de-freno-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'PALANCA DE CAMBIO', 'slug' => 'palanca-de-cambio-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'PROTECTOR', 'slug' => 'protector-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'HORQUILLON', 'slug' => 'horquillon-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'SOPORTE', 'slug' => 'soporte-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'GIROS', 'slug' => 'giros-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'TENSOR DE CADENA', 'slug' => 'tensor-de-cadena-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'ESPEJO', 'slug' => 'espejo', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'MANIJA', 'slug' => 'manija-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'MANILLAR', 'slug' => 'manillar-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'BARRAL INTERNO', 'slug' => 'barral-interno-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'MULETA', 'slug' => 'muleta', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'VARILLA DE FRENO', 'slug' => 'varilla-de-freno-1', 'orden' => null, 'import_file' => null, 'active' => true],
            ['nombre' => 'PECHERA', 'slug' => 'pechera-1', 'orden' => null, 'import_file' => null, 'active' => true],
        ];

        DB::table('family')->insert($families);
    }
}
