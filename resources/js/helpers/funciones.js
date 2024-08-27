
export  async function getEmpleadores()
{
    try{
        const res = await axios.get('/empleadores');
        return res.data;
    }catch (e) {
        return [];
    }
}

