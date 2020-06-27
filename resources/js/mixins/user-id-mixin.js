const UserIdMixin = {
  data() {
    return {
      userId: 0
    }
  },
  mounted() {
    this.userId = parseInt( localStorage.user_id )
  }
}

export default UserIdMixin
