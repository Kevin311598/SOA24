import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";

export default () => {
    const form = useForm({
        event_id: null,
        shipping_address: null,
        event_date: null,
        details: null,
        total: 0.0,
        tortas: []
    })

    const successful = ref(false)

    watch(successful, (value) => {
        if (value) {
            setTimeout(() => {
                successful.value = false
            }, 2000)
        }
    })

    const submit = () => {
        form.post(route('client.order.store'), {
            onSuccess: () => {
                successful.value = true
                form.reset()
            }
        })
    }

    return {
        form,
        successful,
        submit
    }
}
