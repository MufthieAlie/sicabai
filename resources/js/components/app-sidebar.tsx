import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BookOpen, ClipboardList, Folder, LayoutGrid, Leaf, ListChecks, Users } from 'lucide-react';
import { type SharedData } from '@/types';
import AppLogo from './app-logo';

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        url: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        url: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    const { auth } = usePage<SharedData>().props;
    const role = auth.user.role;
    const isAdmin = role === 'admin';
    const mainNavItems: NavItem[] = role === 'user'
        ? [{ title: 'Riwayat Diagnosis', url: '/diagnosis/history', icon: ClipboardList }]
        : [
              { title: 'Dashboard', url: '/dashboard', icon: LayoutGrid },
              ...(isAdmin ? [{ title: 'Pengelolaan Akun', url: '/dashboard/users', icon: Users }] : []),
              { title: 'Data Penyakit', url: '/dashboard/knowledge/penyakits', icon: Leaf },
              { title: 'Data Gejala', url: '/dashboard/knowledge/gejalas', icon: ClipboardList },
              { title: 'Rules Diagnosis', url: '/dashboard/knowledge/rules', icon: ListChecks },
              { title: 'Sinonim Gejala', url: '/dashboard/knowledge/synonyms', icon: BookOpen },
              { title: 'Riwayat Diagnosis', url: '/dashboard/history', icon: ClipboardList },
          ];

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={role === 'user' ? '/diagnosis' : '/dashboard'} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
                <NavMain items={[{ title: 'Mulai Diagnosis', url: '/diagnosis', icon: Leaf }]} />
            </SidebarContent>

            <SidebarFooter>
                {role !== 'user' && <NavFooter items={footerNavItems} className="mt-auto" />}
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
