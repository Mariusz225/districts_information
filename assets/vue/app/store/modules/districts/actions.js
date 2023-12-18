export default {
  async loadDistricts(context, payload) {

    const queryParams = new URLSearchParams();

    Object.entries(payload.filters).forEach(([key, value]) => {
      if (value !== null && value !== '') {
        queryParams.append(key, value);
      }
    });

    const response = await fetch(`/api/district?` + queryParams);

    if (response.ok) {
      const responseData = await response.json();

      const districts = [];

      for (const key in responseData) {
        const district = {
          id: responseData[key].id,
          name: responseData[key].name,
          area: responseData[key].area,
          population: responseData[key].population,
        }
        districts.push(district);
      }

      context.commit('setDistricts', districts)
    }
  },

  async loadDistrict(context, payload) {
    const response = await fetch(
      `/api/district/${payload.id}`
    );

    if (response.ok) {
      const responseData = await response.json();


      const district = {
        id: responseData.id,
        name: responseData.name,
        area: responseData.area,
        population: responseData.population,
        image: null
      }


      context.commit('setDistrict', district)
    }
  },

  async updateDistrict(context, payload) {
    const response = await fetch(
      `/api/district/${payload.district.id}`, {
        method: 'PUT',
        body: JSON.stringify(payload.district)
      }
    );

    if (response.ok) {
      context.commit('setDistrict', payload.district)
    }
  }
}
