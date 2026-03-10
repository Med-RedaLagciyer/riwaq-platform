import { useEffect } from 'react'
import useThemeStore from './store/useThemeStore'

function App() {
  const { theme } = useThemeStore()

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme)
  }, [theme])

  return null
}

export default App