const UserIdMixin = {
  data() {
    return {
      userId: 0
    }
  },
  mounted() {
    this.userId = localStorage.user_id
  }
}

export default UserIdMixin
