export default {
  districts(state) {
    return state.districts
  },

  district: (state) => (id) => {
    return state.districts.find(district => district.id === id)
  },
}
