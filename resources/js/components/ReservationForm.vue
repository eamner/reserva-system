<script setup>
import { reactive, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  reservation: Object,
  isEditing: Boolean,
})

const emit = defineEmits(['saved', 'cancel'])

const form = reactive({
  name: '',
  email: '',
  start_date: '',
  start_hour: '',
  end_date: '',
  end_hour: '',
  description: '',
})

// Cargar datos al editar
watch(
  () => props.reservation,
  (newVal) => {
    if (newVal) {
      form.name  = newVal.user?.name ?? ''
      form.email = newVal.user?.email ?? ''
      form.description = newVal.description ?? ''

      if (newVal.start_time) {
        const [date, time] = newVal.start_time.split(' ')
        form.start_date = date
        form.start_hour = time.slice(0, 5)
      }

      if (newVal.end_time) {
        const [date, time] = newVal.end_time.split(' ')
        form.end_date = date
        form.end_hour = time.slice(0, 5)
      }
    }
  },
  { immediate: true }
)

const submitForm = async () => {
  try {
    const payload = {
      name: form.name,
      email: form.email,
      description: form.description,
      start_time: `${form.start_date} ${form.start_hour}:00`,
      end_time: `${form.end_date} ${form.end_hour}:00`,
    }

    if (props.isEditing) {
      await axios.put(`/api/reservations/${props.reservation.id}`, payload)
    } else {
      await axios.post('/api/reservations', payload)
    }

    emit('saved')
  } catch (error) {
    console.error('Error al guardar:', error)
  }
}
</script>

<template>
  <div>
    <form @submit.prevent="submitForm">

      <label>Nombre</label>
      <input v-model="form.name" type="text" class="w-full border rounded" required />

      <label>Email</label>
      <input v-model="form.email" type="email" class="w-full border rounded" required />

      <label>Fecha inicio</label>
      <input v-model="form.start_date" type="date" class="w-full border rounded" required />

      <label>Hora inicio</label>
      <input v-model="form.start_hour" type="time" class="w-full border rounded" required />

      <label>Fecha fin</label>
      <input v-model="form.end_date" type="date" class="w-full border rounded" required />

      <label>Hora fin</label>
      <input v-model="form.end_hour" type="time" class="w-full border rounded" required />

      <label>Descripción</label>
      <textarea v-model="form.description" class="w-full border rounded"></textarea>

      <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">
        {{ props.isEditing ? 'Actualizar' : 'Crear' }}
      </button>

      <button type="button" class="ml-2 bg-gray-500 text-white p-2 rounded mt-2" @click="emit('cancel')">
        Cancelar
      </button>

    </form>
  </div>
</template>
