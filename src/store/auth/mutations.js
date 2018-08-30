export const setUser = (state, user) => {
  state.user = {
    id: '',
    name: '',
    email: '',
    username: '',
    created_at: '',
    profile: {},
    ...user
  }
}
