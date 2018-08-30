export const setUser = (state, user) => {
  state.user = {
    id: '',
    name: '',
    email: '',
    avatar: '',
    provider: '',
    ...user
  }
}
