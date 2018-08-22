export const updatePageMeta = (state, meta) => {
  state.pageMeta = {
    title: '',
    hash: '',
    icon: '',
    iframeTabs: false,
    backRoute: '/crm',
    tabs: [],
    ...meta
  }
}
