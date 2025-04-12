import React from 'react';
import { usePage } from '@inertiajs/react';

const SocialiteLinks: React.FC = () => {
    const { props } = usePage();
    const providers = props.socialite_providers || {};
    
    // Convert the providers object into an array of { name, icon, ... }
    const providerArray = Object.entries(providers).map(([name, config]) => ({
        name,
        ...config,
    }));

    return (
        <>
            <div className="relative text-center text-sm after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t after:border-border">
                <span className="relative z-10 bg-background px-2 text-muted-foreground">
                    Or continue with
                </span>
            </div>

            <div className="grid grid-cols-2 gap-4">
                {providerArray.map((provider) => (
                    <a
                        key={provider.name}
                        href={route('auth.socialite.redirect', provider.name)}
                        className="inline-flex h-9 items-center justify-center gap-2 whitespace-nowrap rounded-md border border-input bg-background px-4 py-2 text-sm font-medium capitalize shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0"
                    >
                        <span dangerouslySetInnerHTML={{ __html: provider.icon }}></span>
                        <span>{provider.name}</span>
                    </a>
                ))}
            </div>
        </>
    );
};

export default SocialiteLinks;