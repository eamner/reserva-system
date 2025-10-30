<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-lg">
      <h2 class="text-xl font-semibold mb-4">
        {{ isEditing ? 'Editar Reservación' : 'Nueva Reservación' }}
      </h2>

      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Nombre</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border-gray-300 rounded-lg"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border-gray-300 rounded-lg"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Inicio</label>
          <input
            v-model="form.start_time"
            type="datetime-local"
            class="w-full border-gray-300 rounded-lg"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Fin</label>
          <input
            v-model="form.end_time"
            type="datetime-local"
            class="w-full border-gray-300 rounded-lg"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Descripción</label>
          <textarea
            v-model="form.description"
            class="w-full border-gray-300 rounded-lg"
          ></textarea>
        </div>

        <div class="flex justify-end gap-2">
          <button
            type="button"
            @click="emit('close')"
            class="px-4 py-2 bg-gray-300 rounded"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded"
          >
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  reservation: Object,
  isEditing: Boolean,
})

const emit = defineEmits(['saved', 'close'])

const form = reactive({
  name: '',
  email: '',
  start_time: '',
  end_time: '',
  description: '',
})

// Cuando se abre el modal con una reserva para editar
watch(
  () => props.reservation,
  (newVal) => {
    if (newVal) {
      Object.assign(form, newVal)
      form.user_id = newVal.user?.id
      form.resource_id = newVal.resource?.id
      form.description = newVal.description
      form.start_time = newVal.start_time?.replace(' ', 'T').slice(0, 16)
      form.end_time = newVal.end_time?.replace(' ', 'T').slice(0, 16)

    }
  },
  { immediate: true }
)

const submitForm = async () => {
  try {
    const payload = {
    description: form.description,
    start_time: form.start_time ? form.start_time.replace('T', ' ') + ':00' : null,
    end_time: form.end_time ? form.end_time.replace('T', ' ') + ':00' : null,
    user_id: form.user_id ?? props.reservation?.user?.id,
    resource_id: form.resource_id ?? props.reservation?.resource?.id,
    status: form.status ?? props.reservation?.status ?? 'open',
    }
    console.log(payload)
    console.log('reservation en props:', props.reservation)
    console.log('editing id:', props.reservation.id)
    if (props.isEditing) {
      await axios.patch(`/api/reservations/${props.reservation.id}`, payload)
    } else {
      await axios.post('/api/reservations', payload)
    }

    emit('saved')
    emit('close')
  } catch (error) {
    //console.error('Error al guardar:', error)
    console.error('Error al guardar:', error.response?.data ?? error)
  }
}
</script>
