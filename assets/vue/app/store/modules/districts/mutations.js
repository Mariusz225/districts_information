export default {
  setDistricts(state, payload) {
    state.districts = payload;
  },

  setDistrict(state, payload) {
    if (state.districts.length > 0) {

      let district = state.districts.find(district => district.id === payload.id);

      if (district) {

        //TODO Adding timestamp in object district (If app timestamp is different than timestamp in database then district should be updated)
        district = payload;
        return;
      }

    }

    state.districts.unshift(payload);

  }
}
