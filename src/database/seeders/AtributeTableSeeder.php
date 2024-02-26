<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Primero, busca el id de la familia 'casco'
        $familyId = DB::table('family')->where('nombre', 'casco')->first()->id;

        // Asegúrate de que encontraste un id válido antes de intentar insertar
        if (!is_null($familyId)) {
            $atributes = [
                ['idFamily' => $familyId, 'nombre' => 'MARCA', 'slug' => '0', 'valor' => '[\"METZELER\",\"PIRELLI\",\"HORNG FORTUNE\",\"DURO TYRE\"]'],
                ['idFamily' => $familyId, 'nombre' => 'DIAMETRO DE LLANTA', 'slug' => '0', 'valor' => '[\"Rodado 10\\\"\",\"Rodado 11\\\"\",\"Rodado 12\\\"\",\"Rodado 13\\\"\",\"Rodado 14\\\"\",\"Rodado 15\\\"\",\"Rodado 16\\\"\",\"Rodado 17\\\"\",\"Rodado 18\\\"\",\"Rodado 19\\\"\",\"Rodado 20\\\"\",\"Rodado 21\\\"\",\"Rodado 8\\\"\"]'],
                ['idFamily' => $familyId, 'nombre' => 'ANCHO / TALON', 'slug' => '0', 'valor' => '[\"225\",\"250\",\"275\",\"300\",\"325\",\"350\",\"400\",\"410\",\"460\",\"240\\/45\",\"190\\/50\",\"200\\/50\",\"180\\/55\",\"190\\/55\",\"200\\/55\",\"120\\/60\",\"130\\/60\",\"140\\/60\",\"150\\/60\",\"160\\/60\",\"170\\/60\",\"180\\/60\",\"110\\/70\",\"120\\/70\",\"130\\/70\",\"140\\/70\",\"150\\/70\",\"180\\/70\",\"200\\/70\",\"80\\/80\",\"90\\/80\",\"100\\/80\",\"110\\/80\",\"120\\/80\",\"130\\/80\",\"140\\/80\",\"150\\/80\",\"170\\/80\",\"80\\/90\",\"90\\/90\",\"100\\/90\",\"110\\/90\",\"120\\/90\",\"130\\/90\",\"140\\/90\",\"150\\/90\",\"60\\/100\",\"70\\/100\",\"80\\/100\",\"90\\/100\",\"100\\/100\",\"110\\/100\",\"120\\/100\",\"200\\/60\"]'],
                ['idFamily' => $familyId, 'nombre' => 'MODELO', 'slug' => '0', 'valor' => '[\"ROADTEC STREET\",\"ME STREET\",\"SPORTEC M5 INTERACT\",\"PERFECT ME 11\",\"PERFECT ME 77\",\"ME888 MARATHON ULTRA ww\",\"ME880 MARATHON\",\"ME888 MARATHON ULTRA\",\"LASERTEC\",\"ENDURO 3 SAHARA\",\"TOURANCE\",\"TOURANCE NEXT 2\",\"KAROO 3\",\"FEELFREE\",\"ME 7 TEEN\",\"ROADTEC Z8 INTERACT\",\"TOURANCE NEXT\",\"KAROO STREET\",\"DIABLO ROSSO II\",\"DIABLO ROSSO III\",\"SPORT DEMON\",\"NIGHT DRAGON\",\"MT 66 ROUTE\",\"CITY DEMON\",\"CITY CROSS\",\"CITY DRAGON\",\"SUPER CITY\",\"MT 65\",\"SL 26\",\"DIABLO SCOOTER\",\"ANGEL SCOOTER\",\"SL 60\",\"SL 90\",\"MT 60\",\"SCORPION RALLY STR\",\"MT 21 RALLYCROSS\",\"SCORPION MX SOFT\",\"SCORPION MX EXTRA\",\"MT320\",\"DIABLO ROSSO CORSA II\",\"DIABLO ROSSO III\",\"DIABLO \",\"ANGEL GT\",\"ANGEL ST\",\"DIABLO ROSSO SCOOTER\",\"SCORPION TRAIL II\",\"MT 60RS\",\"F806\",\"F807\",\"F851\",\"F861\",\"F866\",\"F870\",\"F871\",\"F872\",\"F873\",\"F875\",\"F876\",\"F878\",\"F879\",\"F882\",\"F886\",\"F888\",\"F889\",\"F890\",\"F895\",\"F897\",\"F898\",\"F901\",\"F914\",\"F916\",\"F920\",\"F921\",\"F923\",\"F928\",\"F929\",\"F931\",\"F932\",\"F933\",\"F936\",\"F937\",\"F938\",\"F938F\",\"F939\",\"F950\",\"F970\",\"MK961\",\"DIABLO ROSSO IV\"]'],
                ['idFamily' => $familyId, 'nombre' => 'TIPO DE MONTAJE', 'slug' => '0', 'valor' => '[\"Uso CON camara\",\"Uso SIN camara\"]'],
                ['idFamily' => $familyId, 'nombre' => 'POSICION', 'slug' => '0', 'valor' => '[\"TRASERA\",\"DELANTERA\",\"DELANTERA \\/ TRASERA\"]'],
                ['idFamily' => $familyId, 'nombre' => 'INDICE DE CARGA', 'slug' => '0', 'valor' => '[\"28\",\"29\",\"30\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"57\",\"58\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"65\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"86\",\"87\",\"88\",\"89\",\"90\",\"33\",\"38\",\"35\",\"26\"]'],
                ['idFamily' => $familyId, 'nombre' => 'INDICE DE VELOCIDAD', 'slug' => '0', 'valor' => '[\"F\",\"G\",\"J\",\"K\",\"L\",\"M\",\"N\",\"P\",\"Q\",\"R\",\"S\",\"T\",\"U\",\"H\",\"V\",\"W\"]'],
                ['idFamily' => $familyId, 'nombre' => 'ORIGEN', 'slug' => '0', 'valor' => '[\"Argentina\",\"Brasil\",\"Alemania\",\"China\",\"Vietnam\"]'],
                ['idFamily' => $familyId, 'nombre' => 'SEGMENTO', 'slug' => '0', 'valor' => '[\"TOURING\",\"URBAN MOBILITY\",\"CRUISING\",\"CUSTOM TOURING\",\"SPORT TOURING\",\"ENDURO ON\\/OFF\",\"ENDURO STREET\",\"PERFORMANCE SCOOTERS\",\"URBAN SCOOTERS Y MOPED\",\"SUPERSPORT \\/ CALLE\",\"SUPERSPORT\\/ SPORT TOURING\",\"SUPERSPORT \\/ CALLE Y CIRCUITO\",\"SUPERSPORT \\/ CUSTOM\",\"SUPERSPORT \\/ URBAN\",\"SCOOTER \\/ RACING\",\"SCOOTER \\/ SPORT\",\"SCOOTER \\/ URBAN\",\"SCOOTER \\/ ON\\/OFF\",\"TRAIL \\/ CALLE\",\"TRAIL \\/ ON\\/OFF\",\"TRAIL \\/ RALLY\",\"MOTOCROSS \\/ ENDURO COMPETICION\",\"MOTOCROSS \\/ MOTOCROOS\",\"MOTOCROSS \\/ CROSS COUNTRY\",\"MOTOCROSS \\/ TRIAL\",\"LINEA STREET\",\"LINEA SCOOTER\",\"LINEA ENDURO\",\"LINEA CROSS OFF ROAD\"]'],
                ];
            DB::table('atribute')->insert($atributes);

        }else{
            echo "No se encontró la familia 'casco'";
        }
        
    }
}
