import { useEffect } from 'react'
import { RouterProvider } from 'react-router-dom'
import router from './router/index'
import useThemeStore from './store/useThemeStore'

function App() {
  const { theme } = useThemeStore()

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme)
  }, [theme])

  return <RouterProvider router={router} />
}

export default App