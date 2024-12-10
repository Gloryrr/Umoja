import * as React from "react"
import { cn } from "./utilsAdmin"
import NavigationHandler from '../Router';
import { LucideIcon } from 'lucide-react';

const Card = React.forwardRef<
  HTMLDivElement,
  React.HTMLAttributes<HTMLDivElement>
>(({ className, ...props }, ref) => (
  <div
    ref={ref}
    className={cn(
      "rounded-lg border bg-card text-card-foreground shadow-sm",
      className
    )}
    {...props}
  />
))
Card.displayName = "Card"

const CardHeader = React.forwardRef<
  HTMLDivElement,
  React.HTMLAttributes<HTMLDivElement>
>(({ className, ...props }, ref) => (
  <div
    ref={ref}
    className={cn("flex flex-col space-y-1.5 p-6", className)}
    {...props}
  />
))
CardHeader.displayName = "CardHeader"

const CardTitle = React.forwardRef<
  HTMLParagraphElement,
  React.HTMLAttributes<HTMLHeadingElement>
>(({ className, ...props }, ref) => (
  <h3
    ref={ref}
    className={cn(
      "text-2xl font-semibold leading-none tracking-tight",
      className
    )}
    {...props}
  />
))
CardTitle.displayName = "CardTitle"

const CardDescription = React.forwardRef<
  HTMLParagraphElement,
  React.HTMLAttributes<HTMLParagraphElement>
>(({ className, ...props }, ref) => (
  <p
    ref={ref}
    className={cn("text-sm text-muted-foreground", className)}
    {...props}
  />
))
CardDescription.displayName = "CardDescription"

const CardContent = React.forwardRef<
  HTMLDivElement,
  React.HTMLAttributes<HTMLDivElement>
>(({ className, ...props }, ref) => (
  <div ref={ref} className={cn("p-6 ", className)} {...props} />
))
CardContent.displayName = "CardContent"

interface DashboardCardProps {
    title: string,
    description: string,
    icon: LucideIcon,
    link: string
}

const DashboardCard = ({ title, description, icon, link }: DashboardCardProps) => {
    return (
      <Card className="overflow-hidden transition-all duration-300 ease-in-out transform hover:scale-105">
        <div className="bg-black p-4 flex items-center justify-between">
          <CardTitle className="text-lg font-semibold text-white">{title}</CardTitle>
          <div className="bg-white rounded-full p-2">
            {React.createElement(icon)}
          </div>
        </div>
        <CardContent className="bg-white">
          <p className="text-sm text-gray-600 pt-2 pb-2">{description}</p>
          <NavigationHandler>
            {(handleNavigation) => (
              <a
              onClick={() => {
                ('Clic détecté');
                handleNavigation(link);
              }}
                className="mt-4 px-6 py-3 bg-black text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 inline-block"
              >
                <h2 className="font-semibold">Voir plus</h2>
              </a>
            )}
          </NavigationHandler>
        </CardContent>
      </Card>
    );
  };

export { Card, CardHeader, CardTitle, CardDescription, CardContent ,DashboardCard}
