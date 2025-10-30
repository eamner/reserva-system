<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Reservaciones</h2>
      <button
        @click="openEditModal()"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
      >
        Nueva Reserva
      </button>
    </div>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left text-gray-700">Nombre</th>
          <th class="px-4 py-2 text-left text-gray-700">Email</th>
          <th class="px-4 py-2 text-left text-gray-700">Fecha</th>
          <th class="px-4 py-2 text-left text-gray-700">Hora</th>
          <th class="px-4 py-2 text-center text-gray-700">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="res in reservations"
          :key="res.id"
          class="border-b hover:bg-gray-50"
        >
          <td class="px-4 py-2">{{ res.user.name }}</td>
          <td class="px-4 py-2">{{ res.user.email }}</td>
          <td class="px-4 py-2">{{ res.start_time }}</td>
          <td class="px-4 py-2">{{ res.end_time }}</td>
          <td class="px-4 py-2 text-center space-x-2">
            <button
              @click="openEditModal(res)"
              class="text-blue-600 hover:underline"
            >
              Editar
            </button>
            <button
              @click="deleteReservation(res.id)"
              class="text-red-600 hover:underline"
            >
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <ReservationModal
      v-if="showEditModal"
      :reservation="selectedReservation"
      :isEditing="isEditing"
      @close="showEditModal = false"
      @saved="fetchReservations" 
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import ReservationModal from './ReservationModal.vue'

const reservations = ref([])
const showEditModal = ref(false)
const selectedReservation = ref(null)
const isEditing = ref(false)

const fetchReservations = async () => {
  const { data } = await axios.get('/api/reservations')
  reservations.value = data
}

onMounted(fetchReservations)

const openEditModal = (res = null) => {
  selectedReservation.value = res ? { ...res } : null
  isEditing.value = !!res
  showEditModal.value = true
}


const closeModal = () => {
  showModal.value = false
}

const deleteReservation = async (id) => {
  if (confirm('¿Seguro que deseas eliminar esta reservación?')) {
    await axios.delete(`/api/reservations/${id}`)
    fetchReservations()
  }
}
</script>
