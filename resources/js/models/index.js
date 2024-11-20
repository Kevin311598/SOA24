export const Event = {
    id: null,
    name: null,
    titulo:null,
    sub_titulo:null,
    imagen_url: null,
}
export const Torta = {
    id: null,
    nombre: null,
    imagen_url: null,
    precio: null,
}

export const Order = {
    id: null,
    user_id: null,
    event_id: null,
    shipping_address: null,
    event_date: null,
    delivery_date: null,
    status: null,
    confirmed_at: null,
    details: null,
    total: 0.00,
    tortas: [],
    event: {},
    customer: {}
}
