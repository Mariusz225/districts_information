export default {
  async loadCities(context, payload) {
    const response = await fetch(`/api/city`);

    if (response.ok) {
      const responseData = await response.json();

      const cities = [];

      for (const key in responseData) {
        const city = {
          id: responseData[key].id,
          name: responseData[key].name,
        }
        cities.push(city);
      }

      context.commit('setCities', cities)
    }
  },
}
