import { create } from 'zustand'
import { persist } from 'zustand/middleware'

const useOrgStore = create(
    persist(
        (set) => ({
            currentOrg: null,
            setCurrentOrg: (org) => set({ currentOrg: org }),
            clearOrg: () => set({ currentOrg: null }),
        }),
        {
            name: 'riwaq-org',
        }
    )
)

export default useOrgStore