export default function getHomeRoute(role) {
    const roles = Array.isArray(role) ? role : [role]

    if (roles.includes('ROLE_ORG_MANAGER') || roles.includes('ROLE_STAFF')) {
        return '/management/dashboard'
    }
    if (roles.includes('ROLE_PROFESSOR')) {
        return '/professor/dashboard'
    }
    if (roles.includes('ROLE_STUDENT')) {
        return '/student/dashboard'
    }

    return '/unauthorized'
}