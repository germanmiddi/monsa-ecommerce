<template>
  <div class="w-full" >

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">            
          <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-2 w-full max-w-7xl mt-5 md:mt-8">
              
              <div class="col-span-2 md:col-span-4 mx-6 text-3xl font-bold"><h1>Estadísticas de Febrero:</h1></div>

              <div class="col-span-2 md:col-span-1 card rounded-xl shadow">
                  <div class="card-body px-2 py-5 flex items-center" >
                      <div class="">
                          <CalendarIcon class="w-10 h-10 mx-4 text-indigo-500" />
                      </div>    
                      <div class="flex-grow flex flex-col px-2">
                          <div class="text-sm text-gray-500">Ordenes</div>
                          <div class="flex items-center justify-between">
                              <div class="font-bold text-2xl">47</div>
                              <span class="text-green-600 text-sm font-bold bg-green-100 py-1 px-2 rounded-xl"> 30%</span>
                          </div>
                      </div>   
                  </div>
                  <div class="card-footer bg-gray-50 px-2  py-3 text-sm rounded-b-xl ">
                      <div class="mx-4 text-indigo-500 font-bold">
                          <a href="#">Ver todo</a>
                      </div>    
                  </div>
              </div>

              <div class="col-span-2 md:col-span-1 card rounded-xl shadow">
                  <div class="card-body px-2 py-5 flex items-center" >
                      <div class="">
                          <TruckIcon class="w-10 h-10 mx-4 text-blue-500" />
                      </div>    
                      <div class="flex-grow flex flex-col px-2">
                          <div class="text-sm text-gray-500">Envios Realizados</div>
                          <div class="flex items-center justify-between">
                              <div class="font-bold text-2xl">35</div>
                              <span class="text-green-600 text-sm font-bold bg-green-100 py-1 px-2 rounded-xl"> 20%</span>
                          </div>
                      </div>   
                  </div>
                  <div class="card-footer bg-gray-50 px-2  py-3 text-sm rounded-b-xl ">
                      <div class="mx-4 text-blue-500 font-bold">
                          <a href="#">Ver todo</a>
                      </div>    
                  </div>
              </div>

              <div class="col-span-2 md:col-span-1 card rounded-xl shadow">
                  <div class="card-body px-2 py-5 flex items-center" >
                      <div class="">
                          <UserIcon name="mapmarkertime" class="w-10 h-10 mx-4 text-blue-500" />
                      </div>    
                      <div class="flex-grow flex flex-col px-2">
                          <div class="text-sm text-gray-500">Nuevos Clientes</div>
                          <div class="flex items-center justify-between">
                              <div class="font-bold text-2xl">45</div>
                              <span class="text-green-600 text-sm font-bold bg-green-100 py-1 px-2 rounded-xl"> 10%</span>
                          </div>
                      </div>   
                  </div>
                  <div class="card-footer bg-gray-50 px-2  py-3 text-sm rounded-b-xl ">
                      <div class="mx-4 text-blue-500 font-bold">
                          <a href="#">Ver todo</a>
                      </div>    
                  </div>
              </div>

              <div class="col-span-2 md:col-span-1 card rounded-xl shadow">
                  <div class="card-body px-2 py-5 flex items-center" >
                      <div class="">
                          <ShoppingCartIcon class="w-10 h-10 mx-4 text-red-500" />
                      </div>    
                      <div class="flex-grow flex flex-col px-2">
                          <div class="text-sm text-gray-500">Ordenes Abandonadas</div>
                          <div class="flex items-center justify-between">
                              <div class="font-bold text-2xl">21</div>
                              <span class="text-red-600 text-sm font-bold bg-red-100 py-1 px-2 rounded-xl"> 12%</span>
                          </div>
                      </div>   
                  </div>
                  <div class="card-footer bg-gray-50 px-2  py-3 text-sm rounded-b-xl ">
                      <div class="mx-4 text-blue-500 font-bold">
                          <a href="#">Ver todo</a>
                      </div>    
                  </div>
              </div>
              
          </div>
      </div>
  </div>  
</template>

<script>
  import Icons from '@/Layouts/Components/Icons.vue'
  import store from '@/store.js'
  import { Bars3Icon,
           XMarkIcon,
           CalendarIcon,
           TruckIcon,
           UserIcon,
           ShoppingCartIcon
          } from '@heroicons/vue/24/outline'

  export default {
      props:{

      },
      components: {
          Bars3Icon,
          CalendarIcon,
          TruckIcon,
          UserIcon,
          ShoppingCartIcon
      },
  
      setup(){
          
      },

      data() {

          const orders = [
              {
                  id: '1',
                  fecha : '25/02/2023',
                  hora: '10:30',
                  client: 'Agencia ABC',
                  origen : 'Ezeiza',
                  destino: 'Hotel Colonial',
                  pasajeros: '4',
                  status: 'PROGRAMADO',
              },
              {
                  id: '2',
                  fecha : '27/02/2023',
                  hora: '07:00',
                  client: 'Agencia ABC',
                  origen : 'Hotel Alvear',
                  destino: 'Estancia La Linda',
                  pasajeros: '4',
                  status: 'PROGRAMADO',
              },
              {
                  id: '3',
                  fecha : '27/02/2023',
                  hora: '07:00',
                  client: 'Agencia ABC',
                  origen : 'Hotel Alvear',
                  destino: 'Estancia La Linda',
                  pasajeros: '4',
                  status: 'PROGRAMADO',
              },
              {
                  id: '3',
                  fecha : '',
                  hora: '',
                  client: '',
                  origen : '',
                  destino: '',
                  pasajeros: '',
                  status: '',
              },

          ];



          return {
              store,    
              btnTextMap: '', 
              filterBtn: true,
              showFilter: true,
              orders: orders,
              filter: {
                  street: "",
                  client: "",
                  driver: "",
                  status: "TODOS",
                  date: [
                      new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000 - 3600000 * 3),
                      new Date(new Date().getTime() - 3600000 * 3)
                  ]
                  //new Date(this.form.date + "T00:00:00.000-03:00")
              },                   
          }
      },
      methods:{
          // showMap() {
          //     this.showFilter = !this.showFilter
          //     if (this.showFilter) {
          //         this.btnTextMap = 'Ver Listado'
          //     } else {
          //         this.btnTextMap = 'Ver Mapa'
          //     }
          // },
      }
  }
</script>