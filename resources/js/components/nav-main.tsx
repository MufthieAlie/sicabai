import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const page = usePage();
    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel className="font-semibold text-green-700 dark:text-green-400">Platform</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton
                                                    asChild
                                                    isActive={item.url === page.url}
                                                    className="rounded-lg hover:bg-green-100 hover:text-green-800 data-[active=true]:bg-green-700 data-[active=true]:text-white data-[active=true]:shadow-sm dark:hover:bg-green-950/60 dark:hover:text-green-200 dark:data-[active=true]:bg-green-700"
                                                >
                            <Link href={item.url} prefetch>
                                {item.icon && <item.icon />}
                                <span>{item.title}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
