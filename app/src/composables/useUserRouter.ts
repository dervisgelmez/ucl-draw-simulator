import router from '@/router/index.router.ts'

export function useUserRouter() {

  const getNavigationRoutes = () => {
    return router
      .getRoutes()
      .filter(
        (route) => route.meta?.showOnSidebar === true
      )
  }

  return { getNavigationRoutes };
}
