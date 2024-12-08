export default function searchByCep(cep, callback = null) {
    const url = "https://viacep.com.br/ws/{cep}/json/";
    if (typeof cep != 'string') return null;
    cep = cep.replace('-', '').trim()
    if (cep.length < 8) return null;
    let _url = url.replace('{cep}', cep)
    fetch(_url)
        .then(res => res.json())
        .then(res => res?.erro ? typeof callback == 'function' && callback(true) : typeof callback == 'function' && callback(false, res))
}
