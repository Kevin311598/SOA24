import {useForm} from "@inertiajs/vue3";

export default () => {
    const form = useForm({
        full_name: "",
        password: "",
        email: ""
    })

    const submit = (url) => {
        form.post(route(url), {
            onFinish: () => form.reset('password'),
        })
    }

    const submitRegister = () => {
        submit("register")
    }

    const submitLogin = () => {
        submit("login")
    }

    return {
        form,
        submitLogin,
        submitRegister
    }
}
